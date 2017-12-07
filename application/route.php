<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
// 林松平操作
Route::rule('admin/','index/Admin/getPage');
Route::rule('checkAdmin/','index/Admin/checkAdmin');
Route::rule('adminLogin/','index/Admin/getLoginPage');
Route::rule('adminLogout/','index/Admin/logout');
Route::rule('addAdmin/','index/Admin/addAdmin');
Route::rule('editAdmin/','index/Admin/editAdmin');
Route::rule('getAllUser/:method','index/admin/getAllUser');
Route::rule('getAllAdmin/','index/admin/getAllAdmin');
Route::rule('getAdmin/:admin','index/admin/getAdmin');
Route::rule('userBan/','index/admin/userBan');
Route::rule('userUnban/','index/admin/userUnban');
Route::rule('userIce/','index/admin/userIce');
Route::rule('userUnice/','index/admin/userUnice');
Route::rule('userDelete/','index/admin/userDelete');
Route::get('getUserByName/:method','index/admin/getUserByName');
Route::rule('dynamicDelete/:id','index/admin/dynamicDelete');
Route::rule('adminDelete/:id','index/admin/adminDelete');
Route::rule('commentsDelete/:id','index/admin/commentsDelete');
Route::rule('messageDelete/:id','index/admin/messageDelete');
Route::rule('getDynamicByWords/:method','index/admin/getDynamicByWords');
Route::rule('getDynamicByName/:method','index/admin/getDynamicByName');
Route::rule('deleteSelectDynamic/','index/admin/deleteSelectDynamic','GET|POST');
Route::rule('getCommentsByWords/:method','index/admin/getCommentsByWords');
Route::rule('getCommentsByName/:method','index/admin/getCommentsByName');
Route::rule('deleteSelectComments/','index/admin/deleteSelectComments','GET|POST');
Route::rule('getAttentionByDate/:date','index/admin/getAttentionByDate');
Route::rule('getGroupAttentionByDate/:date','index/admin/getGroupAttentionByDate');
Route::rule('getGroupAttention/','index/admin/getGroupAttention');
Route::rule('getAttentionByName/','index/admin/getAttentionByName');
Route::rule('addGroupMessage/','index/admin/addGroupMessage');
Route::rule('addPersonalMessage/','index/admin/addPersonalMessage');
Route::rule('deleteSelectAttention/','index/admin/deleteSelectAttention','GET|POST');
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
