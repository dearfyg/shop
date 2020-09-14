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
        $grid->model()->orderBy('id','desc');   //根据id倒叙
        $grid->column('id', __('Id'));
        $grid->column('video_title', __('Video title'));
        $grid->column('video_url', __('Video url'));
        $grid->column('goods_id', __('Goods id'));


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
        $form->text('goods_id', __('Goods id'))->value($id);
        return $form;
    }
}
