<?php

namespace Jvizcaya\Loggable;

use Illuminate\Support\ServiceProvider;
use Jvizcaya\Loggable\Console\Commands\LoggableDelete;

class LoggableServiceProvider extends ServiceProvider
{
      /**
       * Register any application services.
       *
       * @return void
       */
      public function register()
      {
          // Register loggable config file
          $this->mergeConfigFrom(
            __DIR__.'/../config/loggable.php', 'loggable'
          );
      }

      /**
       * Bootstrap any application services.
       *
       * @return void
       */
      public function boot()
      {
            // Load loggable config file
            $this->publishes([
                __DIR__.'/../config/loggable.php' => config_path('loggable.php'),
            ]);

            // Load loggable table migrations
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            // Load loggable commands
            if ($this->app->runningInConsole()) {
                $this->commands([
                  LoggableDelete::class
                ]);
            }
      }
}
