<?php

namespace App\Admin\Controllers;

use App\Model\Goods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Goods';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Goods());

        $grid->column('goods_id', __('Goods id'));
        $grid->column('goods_name', __('Goods name'));
        $grid->column('goods_price', __('Goods price'));
        $grid->column('goods_num', __('Goods num'));
        $grid->column('goods_img', __('Goods img'))->image();
        $grid->column('goods_desc', __('Goods desc'));
        $grid->column('goods_score', __('Goods score'));
        $grid->column('is_new', __('Is new'));
        $grid->column('is_up', __('Is up'));
        $grid->column('cate_id', __('Cate id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $form = new Form(new Goods());

        $form->text('goods_name', __('Goods name'));
        $form->number('goods_price', __('Goods price'));
        $form->number('goods_num', __('Goods num'));
        $form->image('goods_img', __('Goods img'));
        $form->text('goods_desc', __('Goods desc'));
        $form->number('goods_score', __('Goods score'));
        $form->number('is_new', __('Is new'));
        $form->number('is_up', __('Is up'));
        $form->number('cate_id', __('Cate id'));

        return $form;
    }
}
