<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Technician;
use App\Models\Company;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        
        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Check each user type for the email
        $admin = Company::where('c_email', $email)->first();
        $technician = Technician::where('email', $email)->first();
        $user = User::where('email', $email)->first();

        $type = null;
        if ($admin) {
            $type = 'admin';
        } elseif ($technician) {
            $type = 'technician';
        } elseif ($user) {
            $type = 'user';
        }

        if (!$type) {
            return back()->withErrors(['email' => 'Email address not found.']);
        }

        // Delete any existing OTPs for this email
        DB::table('password_resets')
            ->where('email', $email)
            ->delete();

        // Store new OTP with hash
        DB::table('password_resets')->insert([
            'email' => $email,
            'otp' => Hash::make($otp),
            'type' => $type,
            'is_used' => false,
            'created_at' => Carbon::now()
        ]);

        // Send plain OTP email
        Mail::send('emails.reset-password-otp', ['otp' => $otp, 'type' => $type], function($message) use($email) {
            $message->to($email);
            $message->subject('Password Reset OTP');
        });

        return redirect()->route('password.reset.otp.form', ['email' => $email])
            ->with('status', 'We have emailed your password reset OTP!');
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->email;
        
        $passwordReset = DB::table('password_resets')
            ->where('email', $email)
            ->where('is_used', false)
            ->first();
            
        if (!$passwordReset) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid password reset request.']);
        }

        return view('auth.passwords.verify-otp', [
            'email' => $email,
            'type' => $passwordReset->type
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('is_used', false)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (Carbon::parse($passwordReset->created_at)->addMinutes(5)->isPast()) {
            DB::table('password_resets')
                ->where('email', $request->email)
                ->delete();
            return back()->withErrors(['otp' => 'OTP has expired.']);
        }

        // Verify the hashed OTP
        if (!Hash::check($request->otp, $passwordReset->otp)) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // Mark OTP as used but don't delete it
        DB::table('password_resets')
            ->where('email', $request->email)
            ->update([
                'is_used' => true,
                // Reset the created_at timestamp to give more time for password reset
                'created_at' => Carbon::now()
            ]);

        // Pass both email and type to the reset view
        return view('auth.passwords.reset', [
            'email' => $request->email,
            'type' => $passwordReset->type
        ]);
    }
}
