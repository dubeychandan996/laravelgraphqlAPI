<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Authentication\Authenticate;

class Neo4jServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('neo4j', function () {
            $config = config('neo4j.connection');
            return ClientBuilder::create()
                ->withDriver(
                    'neo4j',
                    $config['uri'],
                    Authenticate::basic($config['user'], $config['password'])
                )
                ->build();
        });
    }

    public function boot()
    {
        //
    }
}
