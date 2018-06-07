<?php

namespace App\Tasks\Aliyun;

use App\Tasks\Task;
use Ecs\Request\V20140526\DescribeInstancesRequest;

class EcsTask extends Task
{
    public function instancesAction()
    {
        /** @var \DefaultAcsClient $client */
        $client = di('aliyun');
        $request = new DescribeInstancesRequest();
        $request->setPageSize(10);
        # 发起请求并处理返回
        $response = $client->getAcsResponse($request);

        dump($response);
    }
}
