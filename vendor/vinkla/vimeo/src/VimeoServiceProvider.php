<?php

/*
 * This file is part of Laravel Vimeo.
 *
 * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Vinkla\Vimeo;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Vimeo\Vimeo;

/**
 * This is the Vimeo service provider class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class VimeoServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/vimeo.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('vimeo.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('vimeo');
        }

        $this->mergeConfigFrom($source, 'vimeo');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('vimeo.factory', function () {
            return new VimeoFactory();
        });

        $this->app->alias('vimeo.factory', VimeoFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('vimeo', function (Container $app) {
            $config = $app['config'];
            $factory = $app['vimeo.factory'];

            return new VimeoManager($config, $factory);
        });

        $this->app->alias('vimeo', VimeoManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('vimeo.connection', function (Container $app) {
            $manager = $app['vimeo'];

            return $manager->connection();
        });

        $this->app->alias('vimeo.connection', Vimeo::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            'vimeo',
            'vimeo.factory',
            'vimeo.connection',
        ];
    }
}
