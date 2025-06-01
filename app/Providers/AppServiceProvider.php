<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use MeiliSearch\Client;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);

        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));

        $client->index('products')->updateSettings([
            'searchableAttributes' => ['name'],
        ]);

        $client->index('categories')->updateSettings([
            'searchableAttributes' => ['name'],
        ]);

        $client->index('users')->updateSettings([
            'searchableAttributes' => ['username', 'full_name', 'email'],
        ]);
    }
}
