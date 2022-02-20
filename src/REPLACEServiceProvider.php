<?php

declare(strict_types=1);

namespace ArchTech\REPLACE;

use Illuminate\Support\ServiceProvider;

class REPLACEServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        // $this->loadViewsFrom(__DIR__ . '/../assets/views', 'replace');

        // $this->publishes([
        //     __DIR__ . '/../assets/views' => resource_path('views/vendor/replace'),
        // ], 'replace-views');

        // $this->mergeConfigFrom(
        //     __DIR__ . '/../assets/replace.php',
        //     'replace'
        // );

        // $this->publishes([
        //     __DIR__ . '/../assets/replace.php' => config_path('replace.php'),
        // ], 'replace-config');
    }
}
