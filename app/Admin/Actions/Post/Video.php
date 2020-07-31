<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Video extends RowAction
{
    public $name = '上传视频';
    public function href()
    {
        $goods_id = $this->getKey();
        $goods_name = $this->getRow()->goods_name;
        return "/admin/videos/create?id=".$goods_id."&name=".$goods_name;
    }
    public function handle(Model $model)
    {
        // $model ...
        return $this->response()->success('上传视频成功')->refresh();
    }

}