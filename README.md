<h1 align="center">Illusionist Flysystem Aliyun OSS</h1>
<div align="center">
Flysystem adapter for the Aliyun OSS SDK
<br /><br />

![packagist](https://img.shields.io/packagist/v/illusionist/flysystem-aliyun-oss?style=flat-square)
![php](https://img.shields.io/packagist/php-v/illusionist/flysystem-aliyun-oss?style=flat-square)
![downloads](https://img.shields.io/packagist/dm/illusionist/flysystem-aliyun-oss?style=flat-square)
![license](https://img.shields.io/packagist/l/illusionist/flysystem-aliyun-oss?style=flat-square)
[![Build Status](https://app.travis-ci.com/illusionist-php/flysystem-aliyun-oss.svg?branch=1.x)](https://app.travis-ci.com/illusionist-php/flysystem-aliyun-oss)

<br /><br />
English | [中文](README-zh_CN.md) 
</div>

## Advantages

1. Support Laravel & Lumen
2. Compared with [xxtime/flysystem-aliyun-oss](https://github.com/xxtime/flysystem-aliyun-oss), it is more in line with the [flysystem](https://flysystem.thephpleague.com/docs/architecture/) interface specification. Because the flysystem interface suggests that the return value is array or bool, but [xxtime/flysystem-aliyun-oss](https://github.com/xxtime/flysystem-aliyun-oss) is not very strict about exception handling.
3. Compared to [apollopy/flysystem-aliyun-oss <= 1.2.0](https://github.com/apollopy/flysystem-aliyun-oss) supports visibility get/set.
4. Support Dynamically call OSS SDK methods.

**ps:** The comparison of similar projects is only to highlight the differences. In fact, they are all very good.

## Installation

#### Install via composer

Run the following command to pull in the latest version:

```bash
composer require illusionist/flysystem-aliyun-oss
```

#### Laravel Install

If your laravel version `<=5.4`, Add the service provider to the `providers` array in the `config/app.php` config file as follows:

```php
'providers' => [

    ...

    Illusionist\Flysystem\Aliyun\OssServiceProvider::class,
]
```

##### Lumen Install

Add the following snippet to the `bootstrap/app.php` file under the providers section as follows:

```php
...

// Add this line
$app->register(Illusionist\Flysystem\Aliyun\OssServiceProvider::class);
```

##### Config for Laravel/Lumen

Add the adapter config to the `disks` array in the `config/filesystems.php` config file as follows:

```php

'disks' => [
    ...

    'aliyun-oss' => [

        'driver' => 'aliyun-oss',

        /**
         * The AccessKeyId from OSS or STS.
         */
        'key' => '<your AccessKeyId>',

        /**
         * The AccessKeySecret from OSS or STS
         */
        'secret' => '<your AccessKeySecret>',

        /**
         * The domain name of the datacenter.
         *
         * @example: oss-cn-hangzhou.aliyuncs.com
         */
        'endpoint' => '<endpoint address>',

        /**
         * The bucket name for the OSS.
         */
        'bucket' => '<bucket name>',

        /**
         * The security token from STS.
         */
        'token' => null,

        /**
         * If this is the CName and binded in the bucket.
         *
         * Values: true or false
         */
        'cname' => false,
        
        /**
         * Path prefix
         */
        'prefix' => '',
        
        /**
         *  Request header options.
         * 
         *  @example [x-oss-server-side-encryption => 'KMS']
         */
        'options' => []
    ]
]
```

## Usage

##### Basic

Please refer to [filesystem-api](https://flysystem.thephpleague.com/docs/usage/filesystem-api/).

```php
use Illusionist\Flysystem\Aliyun\OssAdapter;
use League\Flysystem\Filesystem;
use OSS\OssClient;

$client = new OssClient(
    '<your AccessKeyId>',
    '<your AccessKeySecret>',
    '<endpoint address>'
);

$adapter = new OssAdapter($client, '<bucket name>', 'optional-prefix', 'optional-options');
$filesystem = new Filesystem($adapter);

$filesystem->has('file.txt');

// Dynamic call SDK method.
$adapter->setTimeout(30);
$filesystem->getAdapter()->setTimeout(30);

```

##### Laravel/Lumen

Please refer to [filesystem](https://laravel.com/docs/6.x/filesystem)

```php
use Illuminate\Support\Facades\Storage;

Storage::disk('aliyun-oss')->get('path');

// Dynamic call SDK method.
Storage::disk('aliyun-oss')->getAdapter()->setTimeout(30);
```
