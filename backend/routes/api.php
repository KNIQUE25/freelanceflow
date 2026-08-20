<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json(['status' => 'connected']));

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->name('verification.verify')
    ->middleware(['signed', 'throttle:6,1']);

Route::post('/mpesa/callback', [MpesaController::class, 'callback']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/email/resend', [AuthController::class, 'resendVerification']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::get('/business-profile', [BusinessProfileController::class, 'index']);
    Route::post('/business-profile', [BusinessProfileController::class, 'store']);
    Route::match(['put', 'post'], '/business-profile/{profile}', [BusinessProfileController::class, 'update']);
    Route::delete('/business-profile/{profile}', [BusinessProfileController::class, 'destroy']);

    Route::apiResource('clients', ClientController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'pdf']);

    Route::apiResource('payments', PaymentController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::post('/mpesa/stk-push', [MpesaController::class, 'stkPush']);

    Route::get('/reports/revenue', [ReportController::class, 'revenue']);
    Route::get('/reports/invoice-status', [ReportController::class, 'invoiceStatus']);
    Route::get('/reports/client-summary', [ReportController::class, 'clientSummary']);
    Route::get('/reports/payment-methods', [ReportController::class, 'paymentMethods']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
});
