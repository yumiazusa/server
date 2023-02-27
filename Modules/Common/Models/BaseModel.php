<?php
/*
 * @Author: yumiazusa
 * @Date: 2022-12-08 10:24:52
 * @LastEditTime: 2023-02-27 16:39:32
 * @LastEditors: yumiazusa
 * @Description: 用于所有的数据库定义基类
 * @FilePath: /www/miledo/server/Modules/Common/Models/BaseModel.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Common\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class BaseModel extends EloquentModel
{
    /**
     * @name
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/11 10:44
     * @method  GET
     * @param
     * @return JSON
     **/
    protected $primaryKey = 'id';
    /**
     * @name id是否自增
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/11 12:25
     * @return Bool
     **/
    public $incrementing = false;
    /**
     * @name   表id是否为自增
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/11 12:26
     * @return String
     **/
    protected $keyType = 'int';
    /**
     * @name 指示是否自动维护时间戳
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/11 10:36
     * @return Bool
     **/
    public $timestamps = false;
    /**
     * @name 该字段可被批量赋值
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/11 10:40
     * @return Array
     **/
    protected $fillable = [];
    /**
     * @name 该字段不可被批量赋值
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/11 10:40
     * @return Array
     **/
    protected $guarded = [];

    /**
     * @name 时间格式传唤
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/17 16:20
     **/
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
