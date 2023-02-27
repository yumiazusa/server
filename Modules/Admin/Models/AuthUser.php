<?php
/*
 * @Author: yumiazusa
 * @Date: 2022-12-08 10:24:52
 * @LastEditTime: 2023-02-27 16:47:11
 * @LastEditors: yumiazusa
 * @Description: 平台用户模型
 * @FilePath: /www/miledo/server/Modules/Admin/Models/AuthUser.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Admin\Models;


class AuthUser extends BaseApiModel
{
    /**
     * @name 更新时间为null时返回
     * @description
     * @param value String  $value
     * @return Boolean
     **/
    public function getUpdatedAtAttribute($value)
    {
        return $value?$value:'';
    }
    /**
     * @name 隐藏密码
     * @description
     **/
    protected $hidden = [
        'password'
    ];

    /**
     * @name  关联省   多对一
     * @description
     
     **/
    public function province_to()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthArea','province_id','id');
    }
    /**
     * @name  关联市   多对一
     * @description
     
     **/
    public function city_to()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthArea','city_id','id');
    }
    /**
     * @name  关联区县   多对一
     * @description
     
     **/
    public function county_to()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthArea','county_id','id');
    }
}
