<?php

namespace App\Admin\Controllers;

use App\Model\Video;
use App\Model\Goods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VideoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */

    protected $title = 'Video';



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new Video());

        $grid->column('id', __('Id'));
        $grid->column('video_title', __('Video title'));
        $grid->column('video_url', __('Video url'));
        $grid->column('goods_id', __('Goods id'));
        $grid = new Grid(new Goods());

        $grid->column('goods_id', __('商品id'));
        $grid->column('goods_name', __('商品名称'));
        $grid->column('goods_price', __('商品价格'));
        $grid->column('goods_num', __('商品库存'));
        $grid->column('goods_img', __('商品图片'))->image();
        $grid->column('goods_desc', __('商品详情'));
        $grid->column('goods_score', __('商品积分'));
        $grid->column('is_new', __('是否新品'))->display(function ($released) {
            return $released ? '是' : '否';
        });
        $grid->column('is_up', __('是否上架'))->display(function ($released) {
            return $released ? '是' : '否';
        });
        $grid->column('is_hot', __('是否热卖'))->display(function ($released) {
            return $released ? '是' : '否';
        });
        $grid->column('category.cate_name', __('分类'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('修改时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {

        $show = new Show(Video::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('video_title', __('Video title'));
        $show->field('video_url', __('Video url'));
        $show->field('goods_id', __('Goods id'));

        $show = new Show(Goods::findOrFail($id));

        $show->field('goods_id', __('Goods id'));
        $show->field('goods_name', __('Goods name'));
        $show->field('goods_price', __('Goods price'));
        $show->field('goods_num', __('Goods num'));
        $show->field('goods_img', __('Goods img'));
        $show->field('goods_desc', __('Goods desc'));
        $show->field('goods_score', __('Goods score'));
        $show->field('is_new', __('Is new'));
        $show->field('is_up', __('Is up'));
        $show->field('is_hot', __('Is hot'));
        $show->field('cate_id', __('Cate id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        //接id
        $id = empty(request()->id)?null:request()->id;
        //接name
        $name = empty(request()->name)?null:request()->name;
        $form = new Form(new Video());
        $form->text('video_title', __('Video title'))->value($name);
        //处理
        $form->file('video_url', __('Video url'))->uniqueName()->move("video");
        $form->number('goods_id', __('Goods id'))->value($id);

        $form = new Form(new Video());

        $form->text('video_title', __('视频标题'));
        $form->number('goods_id', __('商品id'));
        $form->file("video_url", __("视频"));

        return $form;
    }
}
