<?php
/**
 * User: qbhy
 * Date: 2019-02-02
 * Time: 12:17
 */

namespace Qbhy\Umeng;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class LaravelServiceProvider extends BaseServiceProvider
{

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../config/umeng.php');
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => base_path('config/umeng.php')], 'umeng');
        }
        if ($this->app instanceof LumenApplication) {
            $this->app->configure('umeng');
        }
        $this->mergeConfigFrom($source, 'umeng');
    }

    public function register()
    {
        $this->setupConfig();
        $this->app->singleton(Umeng::class, function ($app) {
            return new Umeng(config('umeng'));
        });
        $this->app->alias(Umeng::class, 'umeng');
    }
}