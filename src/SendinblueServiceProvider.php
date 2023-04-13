<?php

namespace Lquintana\Sendinblue;

use SendinBlue\Client\Configuration;
use Illuminate\Support\ServiceProvider;

class SendinblueServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sendinblue.php', 'sendinblue');

        // Register the service the package provides.
        $this->app->singleton(Sendinblue::class, function ($app) {
            $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $app['config']['sendinblue']['key']);
            return new Sendinblue($config);
        });

        $this->app->alias(Sendinblue::class, 'sendinblue');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sendinblue'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/sendinblue.php' => config_path('sendinblue.php'),
        ], 'sendinblue.config');
    }
}
