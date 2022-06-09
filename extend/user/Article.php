<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-05-29 10:46:24
 * @LastEditTime: 2022-06-09 08:44:48
 * @FilePath: \ypcms\extend\user\Article.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

namespace user;

class Article
{
    //空
    public function __call($method, $params)
    {
    }
    //数据查询后事件
    public function onAfterRead($data)
    {
        $data['url'] =   str_replace(".html", "/" . strtotime($data['create_time']) . ".html", $data['category']['url']);
        return $data;
    }
}
