<?php


namespace Modules\Test\Services;


use Modules\BlogApi\Models\AuthProject;
use Modules\Common\Services\BaseService;
use Modules\Test\Entities\AuthProject as EntitiesAuthProject;

class BaseApiService extends BaseService
{
    protected $projectId = '';
    public function __construct()
    {
        $baseHttp = request()->header('basehttp');
        $id = EntitiesAuthProject::query()->where(['url'=>$baseHttp])->value('id');
        if(!$id){
            $this->apiError('项目不存在！');
        }
        $this->projectId = $id;
        parent::__construct();
    }
}
