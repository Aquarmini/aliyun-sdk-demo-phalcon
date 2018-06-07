<?php

namespace App\Tasks;

use Xin\Cli\Color;

class AliyunTask extends Task
{
    public function mainAction()
    {
        echo Color::head('Help:') . PHP_EOL;
        echo Color::colorize('  Aliyun SDK 测试脚本') . PHP_EOL . PHP_EOL;

        echo Color::head('Usage:') . PHP_EOL;
        echo Color::colorize('  php run aliyun:[action]', Color::FG_LIGHT_GREEN) . PHP_EOL . PHP_EOL;

        echo Color::head('Actions:') . PHP_EOL;
        echo Color::colorize('  ecs@instances               查看所有实例列表', Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize('  ecs@instanceTypes           查看所有实例类型表', Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize('  ecs@createInstance          创建ECS实例', Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize('  ecs@allocatePublicIpAddress 创建ECS实例', Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize('  ecs@images                  镜像列表', Color::FG_LIGHT_GREEN) . PHP_EOL;
    }
}
