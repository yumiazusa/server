<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 16:35:05
 * @LastEditTime: 2023-04-04 14:13:27
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @Description: Grade模型
 * @FilePath: /www/miledo/server/Modules/Students/Entities/College.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Entities;



class Department extends BaseApiModel
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

    protected $table = 'department';

     /**
	 * @name 关联College Attribution
	 * @description
	 * @return JSON
	 **/
    public function departmentAttr()
    {
        return $this->hasMany('Modules\Students\Entities\ClassAttribution','department_id','id');
    }
    

}