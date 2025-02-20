<?php

use App\Models\User;
use App\Models\Technician;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\LogTicketController;
use App\Http\Controllers\User\TrackTicketController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\User\getUserDetailsController;


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
// Update these routes in web.php
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('web', 'guest');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login')
    ->middleware('web');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('web');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

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

    //update technician
    Route::get('/technician/{id}/edit', [TechnicianController::class, 'edit'])->name('technician.update');
    Route::get('/technicians/{id}/edit', [TechnicianController::class, 'edit'])->name('technician.edit');
    Route::put('/technicians/{id}', [TechnicianController::class, 'update'])->name('technician.update');
  
});

//user
Route::get('/user/details', [getUserDetailsController::class, 'getUserDetails']);
Route::get('/log_ticket', [LogTicketController::class, 'create'])->name('log_ticket.create');
Route::post('/log_ticket', [LogTicketController::class, 'handleFormSubmission'])->name('log_ticket.submit');
Route::get('/track_ticket', [TrackTicketController::class, 'index'])->name('track_ticket');


//admin routes
Route::get('/admin/Adminhome', [AdminController::class, 'AdminHome'])->name('admin.admin-home');
Route::get('/admin/incidents', [IncidentController::class, 'index'])->name('admin.incidents');
Route::post('/admin/incidents/assign/{tick_id}', [IncidentController::class, 'assignTechnician'])->name('admin.assignTechnician');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
