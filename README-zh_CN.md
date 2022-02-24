<h1 align="center">Illusionist Flysystem Aliyun OSS</h1>
<div align="center">
适用于 Flysystem 的阿里云 OSS 驱动程序
<br /><br />

![packagist](https://img.shields.io/packagist/v/illusionist/flysystem-aliyun-oss?style=flat-square)
![php](https://img.shields.io/packagist/php-v/illusionist/flysystem-aliyun-oss?style=flat-square)
![downloads](https://img.shields.io/packagist/dm/illusionist/flysystem-aliyun-oss?style=flat-square)
![license](https://img.shields.io/packagist/l/illusionist/flysystem-aliyun-oss?style=flat-square)
[![Build Status](https://app.travis-ci.com/illusionist-php/flysystem-aliyun-oss.svg?branch=master)](https://app.travis-ci.com/illusionist-php/flysystem-aliyun-oss)

<br /><br />
[English](README.md) | 中文
</div>

## 优势

1. 支持 Laravel & Lumen
2. 相比 [xxtime/flysystem-aliyun-oss](https://github.com/xxtime/flysystem-aliyun-oss), 更符合 [flysystem](https://flysystem.thephpleague.com/docs/architecture/) 接口规范. 因为 flysystem 接口期望的返回是 **数组** 或 **布尔型**, 但是 [xxtime/flysystem-aliyun-oss <= 1.5.0](https://github.com/xxtime/flysystem-aliyun-oss) 对异常处理不是很完善
3. 相比 [apollopy/flysystem-aliyun-oss <= 1.2.0](https://github.com/apollopy/flysystem-aliyun-oss) 支持可见性设置
4. 支持动态调用 OSS SDK 方法

**ps:** 同类项目比较仅为突出不同，实际上他们都非常的优秀

## 安装

#### 使用 Composer 安装

运行以下命令获取最新版本：

```bash
composer require illusionist/flysystem-aliyun-oss
```

#### Laravel 安装

如果你的 laravel 版本 `<=5.4`, 请将服务提供者添加到 `config/app.php` 配置文件中的 `providers` 数组中，如下所示:

```php
'providers' => [

    ...

    Illusionist\Flysystem\Aliyun\OssServiceProvider::class,
]
```

##### Lumen 安装

将以下代码片段添加到 `bootstrap/app.php` 文件中的 `providers` 部分位置，如下所示：

```php
...

// Add this line
$app->register(Illusionist\Flysystem\Aliyun\OssServiceProvider::class);
```

##### Laravel/Lumen 的配置

将适配器配置添加到 `config/filesystems.php` 配置文件中的 `disks` 数组，如下所示：

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

## 使用

##### 基本

更详细的 API 请参考 [filesystem-api](https://flysystem.thephpleague.com/docs/usage/filesystem-api/) 文档

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

更新详细的使用请参考 Laravel 的[文件存储](https://learnku.com/docs/laravel/6.x/filesystem/5163) 文档

```php
use Illuminate\Support\Facades\Storage;

Storage::disk('aliyun-oss')->get('path');

// Dynamic call SDK method.
Storage::disk('aliyun-oss')->getAdapter()->setTimeout(30);
```
