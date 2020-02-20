<?php

namespace ChrisRhymes\PolicyCollect\Tests;

use ChrisRhymes\PolicyCollect\Tests\Models\Order;
use ChrisRhymes\PolicyCollect\Tests\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as Provider;

class AuthServiceProvider extends Provider
{
    protected $policies = [
        Order::class => OrderPolicy::class,
    ];


    public function boot()
    {
        $this->registerPolicies();
    }
}