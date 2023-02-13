<?php

namespace Modules\Test\Entities;



class BlogArticleType extends BaseApiModel
{
   
    public function getUpdatedAtAttribute($value)
    {
        return $value?$value:'';
    }
}
