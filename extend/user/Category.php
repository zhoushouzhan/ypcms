<?php
/*
 * @Author: 一品网络技术有限公司
 * @Date: 2022-05-29 10:46:24
 * @LastEditTime: 2022-06-08 11:42:31
 * @FilePath: \ypcms\extend\user\Category.php
 * @Description:
 * 联系QQ:58055648
 * Copyright (c) 2022 by 东海县一品网络技术有限公司, All Rights Reserved.
 */

namespace user;

use think\facade\Db;

class Category
{
    //空
    public function __call($method, $params)
    {
    }
    //读取栏目后生成URL链接
    public static function onAfterWrite()
    {
        $category = Db::name('Category')->order('sort', 'asc')->column('*', 'id');
        $routeCode = "<?php\r\n";
        $routeCode .= "use think\\facade\Route;\r\n";
        foreach ($category as $k => $v) {
            $url = '';
            $route = true;
            $pathArr = explode(',', $v['path'] . ',' . $v['id']);

            foreach ($pathArr as $kk) {
                if ($kk > 0) {
                    if ($category[$kk]['route'] == '') {
                        $route = false;
                    }
                    $url .= '/' . $category[$kk]['route'];
                }
            }
            $routeUrl = $url;
            $url .= '.html';
            //多级栏目有一个不带路由的就不更新
            if ($route) {
                Db::name('Category')->update(['url' =>  $url, 'id' => $k]);
                $routeCode .= "Route::get(\"{$routeUrl}$\", 'index/Category/index', 'GET')->append(['categoryId' => {$v['id']}]);\r\n";
                if ($v['last'] == 1) {
                    $routeCode .= "Route::get(\"{$routeUrl}/:id$\", 'index/Content/index', 'GET')->append(['categoryId' => {$v['id']}]);\r\n";
                }
            }
        }

        $routeFile = APP_PATH . 'index/route/category.php';
        file_put_contents($routeFile, $routeCode);
    }
}
