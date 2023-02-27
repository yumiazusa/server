<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 17:21:36
 * @LastEditTime: 2023-02-27 17:23:36
 * @LastEditors: yumiazusa
 * @Description: 操作日志模型
 * @FilePath: /www/miledo/server/Modules/Students/Entities/AuthOperationLog.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Entities;


class AuthOperationLog extends BaseApiModel
{
    /**
     * @name 关联管理员
     * @description 多对一关系
     * @return JSON
     **/
    public function admin_one()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthAdmin','admin_id','id');
    }
}
