<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2021-11-08 08:30:35
 * @LastEditTime: 2022-05-22 17:39:19
 * @FilePath: \ypcms\app\AppService.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

declare(strict_types=1);

namespace app;

use think\Service;

/**
 * 应用服务类
 */
class AppService extends Service
{
    public function register()
    {
        // 服务注册
        $path = YP_ROOT . '../extend/user/';
        $files = scandir($path);
        foreach ($files as $v) {
            if (is_file($path . $v)) {
                $modName =  pathinfo($path . $v, PATHINFO_FILENAME);
                $className = '\\user\\' . $modName;
                $this->app->bind($modName, $className);
            }
        }
    }

    public function boot()
    {
        // 服务启动
    }
}
