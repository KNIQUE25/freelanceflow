<?php

use Illuminate\Cookie\CookieValuePrefix;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\PublicInvoiceController;
use App\Http\Controllers\ContactController;

// Admin controllers
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminInvoiceController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminAuditLogController;
use App\Http\Controllers\Admin\AdminSystemController;


/*
|--------------------------------------------------------------------------
| Public authentication
|--------------------------------------------------------------------------
*/

Route::get('/csrf-token', function () {
    $token = csrf_token();
    $encrypter = app('encrypter');

    return response()->json([
        'csrf_token' => $token,
        'xsrf_token' => Crypt::encryptString(
            CookieValuePrefix::create('XSRF-TOKEN', $encrypter->getKey()).$token
        ),
    ]);
})->name('csrf.token');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:10,1')
    ->name('register');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login');

Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
    ->middleware('throttle:5,1');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('throttle:5,1');

Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1');

/*
|--------------------------------------------------------------------------
| Public invoice
|--------------------------------------------------------------------------
*/

Route::get('/public/invoice/{uuid}', [PublicInvoiceController::class, 'show']);
Route::post('/public/invoice/{uuid}/pay', [PublicInvoiceController::class, 'pay']);
Route::get('/public/invoice/{uuid}/status', [PublicInvoiceController::class, 'status']);


/*
|--------------------------------------------------------------------------
| M-Pesa callbacks
|--------------------------------------------------------------------------
*/

Route::post('/mpesa/callback', [MpesaController::class, 'callback']);


/*
|--------------------------------------------------------------------------
| Authenticated user routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index']);


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);


    /*
    |--------------------------------------------------------------------------
    | Business Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/business-profile', [BusinessProfileController::class, 'index']);
    Route::post('/business-profile', [BusinessProfileController::class, 'store']);

    Route::put('/business-profile/{profile}', [
        BusinessProfileController::class,
        'update'
    ]);

    Route::post('/business-profile/{profile}', [
        BusinessProfileController::class,
        'update'
    ]);

    Route::delete('/business-profile/{profile}', [
        BusinessProfileController::class,
        'destroy'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Clients
    |--------------------------------------------------------------------------
    */

    Route::apiResource('clients', ClientController::class);


    /*
    |--------------------------------------------------------------------------
    | Invoices
    |--------------------------------------------------------------------------
    */

    Route::apiResource('invoices', InvoiceController::class);

    Route::get('/invoices/{invoice}/pdf', [
        InvoiceController::class,
        'pdf'
    ]);

    Route::get('/invoices/{invoice}/public-url', [
        InvoiceController::class,
        'publicUrl'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */

    Route::apiResource('payments', PaymentController::class)
        ->only([
            'index',
            'store',
            'show',
            'destroy'
        ]);

    Route::post('/payments/{payment}/verify', [
        PaymentController::class,
        'verify'
    ]);


    /*
    |--------------------------------------------------------------------------
    | M-Pesa
    |--------------------------------------------------------------------------
    */

    Route::post('/mpesa/stk-push', [
        MpesaController::class,
        'stkPush'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::get('/notifications', [
        NotificationController::class,
        'index'
    ]);

    Route::post('/notifications/read-all', [
        NotificationController::class,
        'markAllRead'
    ]);

    Route::post('/notifications/{id}/read', [
        NotificationController::class,
        'markAsRead'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::get('/reports/client-summary', [
        ReportController::class,
        'clientSummary'
    ]);

    Route::get('/reports/invoice-status', [
        ReportController::class,
        'invoiceStatus'
    ]);

    Route::get('/reports/payment-methods', [
        ReportController::class,
        'paymentMethods'
    ]);

    Route::get('/reports/revenue', [
        ReportController::class,
        'revenue'
    ]);


    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    |
    | These controllers are inside:
    | app/Http/Controllers/Admin/
    |
    */

    Route::prefix('admin')
        ->middleware('admin')
        ->group(function () {

            /*
            | Admin Dashboard
            */
            Route::get('/dashboard', [
                AdminDashboardController::class,
                'index'
            ]);


            /*
            | Users
            */
            Route::get('/users', [
                AdminUserController::class,
                'index'
            ]);

            Route::get('/users/{user}', [
                AdminUserController::class,
                'show'
            ]);

            Route::delete('/users/{user}', [
                AdminUserController::class,
                'destroy'
            ]);

            Route::post('/users/{user}/activate', [
                AdminUserController::class,
                'activate'
            ]);

            Route::post('/users/{user}/suspend', [
                AdminUserController::class,
                'suspend'
            ]);


            /*
            | Admin Invoices
            */
            Route::get('/invoices', [
                AdminInvoiceController::class,
                'index'
            ]);

            Route::get('/invoices/{invoice}', [
                AdminInvoiceController::class,
                'show'
            ]);


            /*
            | Admin Payments
            */
            Route::get('/payments', [
                AdminPaymentController::class,
                'index'
            ]);

            Route::get('/payments/{payment}', [
                AdminPaymentController::class,
                'show'
            ]);


            /*
            | Audit Logs
            */
            Route::get('/audit-logs', [
                AdminAuditLogController::class,
                'index'
            ]);


            /*
            | System
            */
            Route::get('/logs', [
                AdminSystemController::class,
                'logs'
            ]);

            Route::post('/clear-cache', [
                AdminSystemController::class,
                'clearCache'
            ]);
        });
});