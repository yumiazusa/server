<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 16:35:05
 * @LastEditTime: 2023-03-12 23:14:14
 * @LastEditors: yumiazusa
 * @Description: Students模型
 * @FilePath: /www/miledo/server/Modules/Students/Entities/Students.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Entities;

class Students extends BaseApiModel
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

    protected $table = 'students';
    /**
     * @name 隐藏密码
     * @description
     **/
    protected $hidden = [
        'password'
    ];

    

}
