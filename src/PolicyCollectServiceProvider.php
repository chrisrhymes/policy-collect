<?php

namespace ChrisRhymes\PolicyCollect;

use \Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PolicyCollectServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {

    }

    public function boot()
    {
        // Pass in a collection of eloquent models and optionally an array of additional policy methods to check
        Collection::macro('policy', function ($additionalMethods = []) {
            return $this->map( function ($model) use ($additionalMethods) {
                
                if (!$model instanceof Model) {
                    throw new Exception('$model is not an instanceof Model');
                }

                $methods = collect([
                    'view',
                    'update',
                    'delete',
                    'restore',
                    'forceDelete'
                ])->merge($additionalMethods);

                $model->can = new \stdClass();

                $methods->each( function($method) use ($model) {
                    $model->can->{$method} = auth()->check() && auth()->user()->can($method, $model);
                });

                return $model;
            });
        });
    }
}
