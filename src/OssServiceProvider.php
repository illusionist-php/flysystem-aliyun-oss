<?php

namespace Illusionist\Flysystem\Aliyun;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use OSS\OssClient;

class OssServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('aliyun-oss', function ($app, $config) {

            $client = @new OssClient(
                $config['key'],
                $config['secret'],
                ($url = $config['endpoint']),
                $config['cname'],
                $config['token']
            );

            if (isset($config['url'])) {
                $url = $config['url'];
            } elseif ($config['cname'] === false) {
                $url = '';
            }

            $prefix = isset($config['prefix']) ? $config['prefix'] : '';
            $options = isset($config['options']) ? $config['options'] : [];

            return new Filesystem(new OssAdapter($client, $config['bucket'], $url, $prefix, $options));
        });
    }
}
