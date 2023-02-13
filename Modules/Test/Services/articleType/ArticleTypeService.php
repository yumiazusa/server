<?php

namespace Modules\Test\Services\articleType;




use Modules\Test\Entities\BlogArticleType;
use Modules\Test\Services\BaseApiService;

class ArticleTypeService extends BaseApiService
{
   public function typeList(){
      $model =BlogArticleType::query();
      $list = $model->select('id','name','pid')
            ->where(['status'=>1,'project_id'=>$this->projectId])
            ->orderBy('sort','asc')->orderBy('id','desc')
            ->get()->toArray();
      return $this->apiSuccess('获取成功',$this->tree($list));
   }
}
