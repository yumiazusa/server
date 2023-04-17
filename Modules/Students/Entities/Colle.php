<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 16:35:05
 * @LastEditTime: 2023-04-07 15:27:38
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @Description: College模型
 * @FilePath: /www/miledo/server/Modules/Students/Entities/College.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Entities;



class Colle extends BaseApiModel
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

    protected $table = 'college';
    

}
