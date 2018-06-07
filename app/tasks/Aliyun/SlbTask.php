<?php

namespace App\Tasks\Aliyun;

use App\Tasks\Task;
use Slb\Request\V20140515\AddBackendServersRequest;
use Slb\Request\V20140515\DescribeLoadBalancersRequest;
use Slb\Request\V20140515\RemoveBackendServersRequest;
use Xin\Phalcon\Cli\Traits\Input;

class SlbTask extends Task
{
    use Input;

    public function instancesAction()
    {
        $loadBalancerIds = $this->argument('loadbalancer_id');

        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');
        $request = new DescribeLoadBalancersRequest();
        $request->setPageSize(10);
        if ($loadBalancerIds) {
            if (!is_array($loadBalancerIds)) {
                $loadBalancerIds = [$loadBalancerIds];
            }
            $request->setLoadBalancerId(implode(',', $loadBalancerIds));
        }
        # 发起请求并处理返回
        $response = $client->getAcsResponse($request);

        // $response->LoadBalancers->LoadBalancer[0]->LoadBalancerId
        dump($response);
    }

    public function addServersAction()
    {
        $loadBalancerId = $this->argument('loadbalancer_id', 'lb-uf6buy2wsnd801rp8etfc');
        $serverIds = $this->argument('server_id', 'i-uf61ka2bsb0465tyai9d');

        if (!is_array($serverIds)) {
            $serverIds = [$serverIds];
        }

        $servers = [];
        foreach ($serverIds as $serverId) {
            $servers[] = [
                'ServerId' => $serverId,
                'Weight' => 100,
            ];
        }

        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');
        $request = new AddBackendServersRequest();
        $request->setLoadBalancerId($loadBalancerId);
        $request->setBackendServers(json_encode($servers));

        $response = $client->getAcsResponse($request);

        // $response->LoadBalancers->LoadBalancer[0]->LoadBalancerId
        dump($response);
    }

    public function removeServersAction()
    {
        $loadBalancerId = $this->argument('loadbalancer_id', 'lb-uf6buy2wsnd801rp8etfc');
        $serverIds = $this->argument('server_id', 'i-uf61ka2bsb0465tyai9d');

        if (!is_array($serverIds)) {
            $serverIds = [$serverIds];
        }

        $servers = [];
        foreach ($serverIds as $serverId) {
            $servers[] = [
                'ServerId' => $serverId,
                'Weight' => 100,
            ];
        }

        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');
        $request = new RemoveBackendServersRequest();
        $request->setLoadBalancerId($loadBalancerId);
        $request->setBackendServers(json_encode($servers));

        $response = $client->getAcsResponse($request);

        // $response->LoadBalancers->LoadBalancer[0]->LoadBalancerId
        dump($response);
    }
}

