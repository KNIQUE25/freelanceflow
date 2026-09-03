<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\BusinessProfile;
use App\Policies\ClientPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\PaymentPolicy;
use App\Policies\BusinessProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Client::class => ClientPolicy::class,
        Invoice::class => InvoicePolicy::class,
        Payment::class => PaymentPolicy::class,
        BusinessProfile::class => BusinessProfilePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}