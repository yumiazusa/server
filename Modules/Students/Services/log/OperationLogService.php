<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-03-04 17:23:58
 * @LastEditTime: 2023-03-04 17:25:16
 * @LastEditors: yumiazusa
 * @Description: 日志记录服务
 * @FilePath: /www/miledo/server/Modules/Students/Services/log/OperationLogService.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Services\log;


use Modules\Students\Entities\AuthOperationLog;
use Modules\Students\Services\BaseApiService;

class OperationLogService extends BaseApiService
{
    /**
     * @name 添加日志记录
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/12 3:29
     * @param admin_id Int 管理员id
     * @param content String 操作描述
     * @return JSON
     **/
    public function store(int $admin_id = 0,string $content = '')
    {
        if($admin_id){
            $route_data = request()->route();
            $url = $route_data->uri;
            $data = [
                'content'=>$content,
                'url'=>$url,
                'method'=>request()->getMethod(),
                'ip'=>isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR']:'',
                'admin_id'=>$admin_id,
                'data'=>json_encode(request()->all()),
                'header'=>json_encode(request()->header())
            ];
            if($data['content'] == ''){
                $data['content'] = urldecode(request()->header('breadcrumb'));
            }
            $this->commonCreate(AuthOperationLog::query(),$data);
        }
    }

    /**
     * @name 管理员列表
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/12 3:03
     * @param  data Array 查询相关参数
     * @param  data.page Int 页码
     * @param  data.limit Int 每页显示条数
     * @param  data.url String 操作路由
     * @param  data.method String 请求方式
     * @param  data.username String 管理员账号
     * @param  data.created_at Array 创建时间
     * @return JSON
     **/
    public function index(array $data)
    {
        $model = AuthOperationLog::query();
        $model = $this->queryCondition($model,$data,'url');
        if (isset($data['admin_id']) && $data['admin_id'] > 0){
            $model = $model->where('admin_id',$data['admin_id']);
        }
        if(!empty($data['method'])){
            $model = $model->where('method', 'like', '%' . $data['method'] . '%');
        }
        $list = $model->with([
                'admin_one'=>function($query){
                    $query->select('id','username');
                }
            ])
            ->whereHas('admin_one',function($query)use ($data){
                if(!empty($data['username'])){
                    $query->where('username', 'like', '%' . $data['username'] . '%');
                }
            })
            ->orderBy('id','desc')
            ->paginate($data['limit'])
            ->toArray();
        return $this->apiSuccess('',[
            'list'=>$list['data'],
            'total'=>$list['total']
        ]);
    }
    /**
     * @name 删除
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:16
     * @param id Int id
     * @return JSON
     **/
    public function cDestroy(int $id){
        return $this->commonDestroy(AuthOperationLog::query(),[$id]);
    }
    /**
     * @name 批量删除
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:16
     * @param idArr Array id数组
     * @return JSON
     **/
    public function cDestroyAll(array $idArr){
        return $this->commonDestroy(AuthOperationLog::query(),$idArr);
    }
}
