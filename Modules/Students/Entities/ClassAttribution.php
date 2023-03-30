<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-23 18:12:56
 * @LastEditors: yumiazusa
 * @LastEditTime: 2023-03-26 17:09:25
 * @FilePath: /www/miledo/server/Modules/Students/Entities/ClassAttribution.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace Modules\Students\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassAttribution extends Model
{
    use HasFactory;

    protected $table = 'class_attribution';

}