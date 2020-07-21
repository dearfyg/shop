<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
class Category extends Model
{
    use ModelTree,AdminBuilder;

    protected $table = 'Category';
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setParentColumn('p_id');  // 父ID
        $this->setOrderColumn('sort'); // 排序
        $this->setTitleColumn('cate_name'); // 标题
    }
}
