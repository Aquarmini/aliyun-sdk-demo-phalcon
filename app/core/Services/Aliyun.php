<?php
// +----------------------------------------------------------------------
// | Aliyun.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use DefaultProfile;
use DefaultAcsClient;

class Aliyun implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        $di->setShared('aliyun', function () {
            require_once ROOT_PATH . '/libs/aliyun-openapi-php-sdk/aliyun-php-sdk-core/Config.php';

            $accessKey = di('config')->aliyun->accessKeyID;
            $accessSecret = di('config')->aliyun->accessKeySecret;
            $profile = DefaultProfile::getProfile("cn-shanghai", $accessKey, $accessSecret);
            $client = new DefaultAcsClient($profile);
            return $client;
        });
    }
}
