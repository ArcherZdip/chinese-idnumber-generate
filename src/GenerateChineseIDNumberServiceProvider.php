<?php

namespace ArcherZdip\GenerateIDNumber;

use Illuminate\Support\ServiceProvider;

class GenerateChineseIDNumberServiceProvider extends ServiceProvider
{
    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = false; // 延迟加载服务

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // 单例绑定服务
        $this->app->singleton('chinese_id_faker', function ($app) {
            return new GenerateChineseIDNumberService();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['chinese_id_faker'];
    }
}
