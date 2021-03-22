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
            ], 'config');

            // Load migration file
            $this->publishes([
              __DIR__.'/../database/migrations/create_logs_table.php' =>
                database_path('migrations').'/'.now()->format('Y_m_d').'_000000_create_logs_table.php'
            ], 'migrations');

            // Load loggable commands
            if ($this->app->runningInConsole()) {
                $this->commands([
                  LoggableDelete::class
                ]);
            }
      }
}
