<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\User;
use App\Models\Technician;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Mail;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    

    // public function showResetForm(Request $request, $token = null)
    // {
    //     return view('auth.passwords.reset')->with(
    //         ['token' => $token, 'email' => $request->email]
    //     );
    // }


    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'type' => 'required|in:admin,technician,user'
        ]);

        try {
            $passwordReset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('type', $request->type)
                ->where('is_used', true)
                ->first();

            if (!$passwordReset) {
                return back()->withErrors(['email' => 'Invalid password reset request.']);
            }

            // Update password based on user type
            switch($request->type) {
                case 'admin':
                    Company::where('c_email', $request->email)
                        ->update(['password' => Hash::make($request->password)]);
                    break;
                case 'technician':
                    Technician::where('email', $request->email)
                        ->update(['password' => Hash::make($request->password)]);
                    break;
                case 'user':
                    User::where('email', $request->email)
                        ->update(['password' => Hash::make($request->password)]);
                    break;
            }

            // Delete the reset record
            DB::table('password_resets')->where('email', $request->email)->delete();

            return redirect()->route('login')
                ->with('success', 'Your password has been reset successfully!');

        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Error resetting password. Please try again.']);
        }
    }
}
