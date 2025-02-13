<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Technician;
use App\Models\Company;

class LoginController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Login Controller
    |----------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application
    | and redirecting them to their home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'emailAddress' => 'required',
            'password' => 'required',
            'status' => 'required|in:admin,Technician,User', // Ensure user status is selected
        ]);

        // Extract status and credentials from the request
        $status = $request->input('status');
        $email = $request->input('emailAddress');
        $password = $request->input('password');

        // Call appropriate login method based on status
        switch ($status) {
            case 'admin':
                return $this->adminLogin($email, $password);
            case 'Technician':
                return $this->technicianLogin($email, $password);
            case 'User':
                return $this->userLogin($email, $password);
            default:
                return back()->withErrors(['status' => 'Invalid user type selected.']);
        }
    }


    // Admin login method
private function adminLogin($admin_no, $password)
{
    $admin = Company::where('admin_no', $admin_no)->first();

    if (!$admin) {
        return back()->withErrors(['emailAddress' => 'Admin number not found'])->withInput();
    }

       // Debugging output
        // dd([
        //     'admin_no' => $admin_no,
        //     'raw_password_provided' => $password,
        //     'hashed_provided_password' => Hash::make($password),
        //     'password_from_db' => $admin->password,
        //     'direct_match' => ($password === $admin->password),
        //     'hash_check' => Hash::check($password, $admin->password),
        //     'password_length' => strlen($password),
        //     'hash_length' => strlen($admin->password)
        // ]);

    // Case 1: Password is already in bcrypt format
    if ($admin->password_updated) {
        if (Hash::check($password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            session()->flash('loginSuccess', 'Welcome Administrator! You have successfully logged in.');
            return redirect()->intended(route('adminpage'));
        }
    }
    // Case 2: Password is in MD5 format and needs upgrade
    else if (strlen($admin->password) === 32 && md5($password) === $admin->password) {
        if ($this->upgradeAdminPassword($admin, $password)) {
            Auth::guard('admin')->login($admin);
            session()->flash('loginSuccess', 'Welcome Administrator! You have successfully logged in.');
            return redirect()->intended(route('adminpage'));
        }
    }

    // If we get here, authentication failed
    return back()->withErrors(['emailAddress' => 'Invalid password'])->withInput();
}

private function upgradeAdminPassword($admin, $password)
{
    DB::beginTransaction();
    try {
        // Hash the password using bcrypt
        $hashedPassword = Hash::make($password);
        
        // Update the admin's password and mark it as updated
        $admin->password = $hashedPassword;
        $admin->password_updated = true;
        
        if (!$admin->save()) {
            throw new \Exception('Failed to save new password');
        }
        
        DB::commit();
        return true;
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Failed to upgrade admin password: ' . $e->getMessage());
        return false;
    }
}

//Service Provider
private function technicianLogin($email, $password)
{
    // Fetch the technician using their email
    $technician = Technician::where('email', $email)->first();

    if (!$technician) {
        return back()->withErrors(['emailAddress' => 'Technician email not found'])->withInput();
    }

    // Debugging (optional)
    // dd($technician, Hash::check($password, $technician->password));

    // Case 1: Password is already in bcrypt format
    if ($technician->password_updated) {
        if (Hash::check($password, $technician->password)) {
            // Authenticate using the 'technician' guard
            Auth::guard('technician')->login($technician);
            session()->flash('loginSuccess', 'Welcome Service Provider! You have successfully logged in.');
            return redirect()->intended(route('technician.logged'));
        }
    }
    // Case 2: Password is in MD5 format and needs upgrade
    elseif (strlen($technician->password) === 32 && md5($password) === $technician->password) {
        if ($this->upgradeTechnicianPassword($technician, $password)) {
            Auth::guard('technician')->login($technician);
            session()->flash('loginSuccess', 'Welcome Service Provider! You have successfully logged in.');
            return redirect()->intended(route('technician.logged'));
        }
    }

    // If we get here, authentication failed
    return back()->withErrors(['emailAddress' => 'Invalid password'])->withInput();
}


private function upgradeTechnicianPassword($technician, $password)
{
    DB::beginTransaction();
    try {
        // Hash the password using bcrypt
        $hashedPassword = Hash::make($password);
        
        // Update the technician's password and mark it as updated
        $technician->password = $hashedPassword;
        $technician->password_updated = true;
        
        if (!$technician->save()) {
            throw new \Exception('Failed to save new password');
        }
        
        DB::commit();
        return true;
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Failed to upgrade technician password: ' . $e->getMessage());
        return false;
    }
}


    // User login method
    public function userLogin($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['emailAddress' => 'User email not found'])->withInput();
        }

        if (Hash::check($password, $user->password)) {
            Auth::login($user);
            
            // Store essential user data in session
            Session::put('email', $user->email);
            Session::put('user_id', $user->user_id);
            Session::put('name', $user->first_name . ' ' . $user->last_name);
            Session::put('company_id', $user->company_id);
            
            session()->flash('loginSuccess', 'Welcome User! You have successfully logged in.');
            return redirect()->intended(route('log_ticket.create'));
        }

        return back()->withErrors(['emailAddress' => 'Invalid password'])->withInput();
    }

    protected function authenticated(Request $request, $user)
    {
        // Store user's full name in session
        Session::put('name', $user->first_name . ' ' . $user->last_name);
        return redirect()->route('log_ticket.create');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('status', 'You have been logged out successfully');
    }

}
