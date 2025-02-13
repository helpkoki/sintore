<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TechnicianAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\User\getUserDetailsController;
use App\Http\Controllers\User\TrackTicketController;
use App\Http\Controllers\User\LogTicketController;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/otp/{email}', [ForgotPasswordController::class, 'showOtpForm'])->name('password.reset.otp.form');
Route::post('password/reset/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.otp');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('/service-provider', [TechnicianController::class, 'getLoggedTickets'])->name('logged');

//test
Route::get('/admin', function () {
    return view('adminpage');
})->name('adminpage');


//service provider
Route::middleware(['auth:technician'])->group(function () { 

    // Dashboard Routes
    Route::get('/dashboard/analytics', [App\Http\Controllers\AnalyticsController::class, 'getDashboardData'])
        ->name('technician.dashboard');
     
    //Status Routes    
    Route::get('/technician/logged', [TechnicianController::class, 'logged'])->name('technician.logged');
    Route::get('/technician/ticket/{ticketId}', [TechnicianController::class, 'getTicketDetails']);
    Route::post('/technician/ticket/{ticketId}/status', [TechnicianController::class, 'updateStatus']);
    Route::get('/technician/in_progress', [TechnicianController::class, 'inProgress'])->name('technician.in_progress');
    Route::get('/technician/escalated', [TechnicianController::class, 'escalated'])->name('technician.escalated');
    Route::get('/technician/completed', [TechnicianController::class, 'completed'])->name('technician.completed');

    Route::post('/technician/ticket/{id}/escalate', [TechnicianController::class, 'escalateTicket']);
  
});

//user
Route::get('/user/details', [getUserDetailsController::class, 'getUserDetails']);
Route::get('/log_ticket', [LogTicketController::class, 'create'])->name('log_ticket.create');
Route::post('/log_ticket', [LogTicketController::class, 'handleFormSubmission'])->name('log_ticket.submit');
Route::get('/track_ticket', [TrackTicketController::class, 'index'])->name('track_ticket');


