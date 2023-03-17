<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-03-14 23:27:04
 * @LastEditTime: 2023-03-17 11:23:39
 * @LastEditors: yumiazusa
 * @Description: 管理员修改密码服务
 * @FilePath: /www/miledo/server/Modules/Students/Services/Students/UpdatePasswordService.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Services\Students;


use Modules\Students\Entities\Students;
use Modules\Admin\Services\auth\TokenService;
use Modules\Students\Services\BaseApiService;

class UpdatePasswordService extends BaseApiService
{
    /**
     * @name 修改密码
     * @description
     * @param  data  Array  用户数据
     * @param  data.y_password String 原密码
     * @param  data.password String 密码
     * @return JSON
     **/
    public function upadtePwd(array $data){
        if (password_verify($data['y_password'], Students::where('id',$data['id'])->value('password'))) {
            if(Students::where('id',$data['id'])->update(['password'=>bcrypt($data['password'])])){
                return $this->apiSuccess('修改成功！');
            }
            $this->apiError('修改失败！');
        }
        $this->apiError('原密码错误！');
    }
}
