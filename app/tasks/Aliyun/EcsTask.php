<?php

namespace App\Tasks\Aliyun;

use App\Tasks\Task;
use Ecs\Request\V20140526\AllocatePublicIpAddressRequest;
use Ecs\Request\V20140526\CreateInstanceRequest;
use Ecs\Request\V20140526\DescribeImagesRequest;
use Ecs\Request\V20140526\DescribeInstancesRequest;
use Ecs\Request\V20140526\DescribeInstanceStatusRequest;
use Ecs\Request\V20140526\DescribeInstanceTypesRequest;
use Ecs\Request\V20140526\RunInstancesRequest;
use Ecs\Request\V20140526\StartInstanceRequest;
use Xin\Cli\Color;
use Xin\Phalcon\Cli\Traits\Input;

class EcsTask extends Task
{
    use Input;

    public function instancesAction()
    {
        $instanceId = $this->argument('instance_id');

        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');
        $request = new DescribeInstancesRequest();
        $request->setPageSize(10);
        if ($instanceId) {
            if (!is_array($instanceId)) {
                $instanceId = [$instanceId];
            }
            $request->setInstanceIds(json_encode($instanceId));
        }
        # 发起请求并处理返回
        $response = $client->getAcsResponse($request);

        // $response->Instances->Instance[0]->InnerIpAddress->IpAddress[0]
        // $response->Instances->Instance[0]->PublicIpAddress->IpAddress[0]
        // $response->Instances->Instance[0]->VpcAttributes->PrivateIpAddress->IpAddress[0]
        dump($response);
    }

    public function instanceTypesAction()
    {
        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');
        $request = new DescribeInstanceTypesRequest();
        $response = $client->getAcsResponse($request);

        foreach ($response->InstanceTypes->InstanceType as $key => $item) {
            // if ($item->InstanceTypeId == 'ecs.t5-lc2m1.nano') {
            //     dd($item);
            // }
            echo Color::colorize('instanceTypeId: ' . $item->InstanceTypeId, Color::FG_LIGHT_GREEN) . PHP_EOL;
        }
    }

    public function imagesAction()
    {
        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');

        $request = new DescribeImagesRequest();
        $response = $client->getAcsResponse($request);

        dd($response);
    }

    public function createInstanceAction()
    {
        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');

        $request = new CreateInstanceRequest();
        // 镜像ID
        $request->setImageId('m-uf6gy4mut8te58tg07bv');
        // 实例类型
        $request->setInstanceType('ecs.t5-lc2m1.nano');
        // 计费方式 PostPaid按量计费 PrePaid包年包月
        $request->setInstanceChargeType('PostPaid');
        // 区域
        $request->setRegionId('cn-shanghai');
        // 安全组ID
        $request->setSecurityGroupId('sg-uf61jguofhwhc0sb6lik');
        // 网络计费方式 PayByBandwidth固定带宽计费 PayByTraffic按流量计费
        $request->setInternetChargeType('PayByTraffic');
        // 公钥对
        $request->setKeyPairName('limx-mac');
        // 当实例类型为VPC网络时 设置
        $request->setVSwitchId('vsw-uf6ceq1yxkx24uo0t29z7');
        // 最大带宽
        $request->setInternetMaxBandwidthOut('5');

        $response = $client->getAcsResponse($request);

        // $response->InstanceId
        dd($response);
    }

    public function allocatePublicIpAddressAction()
    {
        $instanceId = $this->argument('instance_id', 'i-uf61ka2bsb0465tyai9d');
        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');

        $request = new AllocatePublicIpAddressRequest();
        $request->setInstanceId($instanceId);

        $response = $client->getAcsResponse($request);

        // $response->IpAddress
        dd($response);
    }

    public function startAction()
    {
        $instanceId = $this->argument('instance_id', 'i-uf61ka2bsb0465tyai9d');
        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');

        $request = new StartInstanceRequest();
        $request->setInstanceId($instanceId);

        $response = $client->getAcsResponse($request);

        dd($response);
    }

    public function statusAction()
    {
        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');

        $request = new DescribeInstanceStatusRequest();

        $response = $client->getAcsResponse($request);

        dd($response);
    }

    public function serverAction()
    {
        $ip = $this->argument('ip', '47.100.114.162');

        $sh = 'ssh -tt root@' . $ip . ' "service nginx start && service php72-php-fpm start && service redis start && service mariadb start"';
        $res = exec($sh);
        dd($res);
    }
}
