<?php

namespace App\Admin\Controllers;

use App\Model\Prize;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PrizeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Prize';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Prize());

        $grid->column('id', __('Id'));
        $grid->column('prize_name', __('Prize name'));
        $grid->column('prize_rand', __('Prize rand'));
        $grid->column('prize_num', __('Prize num'));
        $grid->column('prize_level', __('Prize level'));
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete(); //禁止行级删除路由
        });
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
        $show = new Show(Prize::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('prize_name', __('Prize name'));
        $show->field('prize_rand', __('Prize rand'));
        $show->field('prize_num', __('Prize num'));
        $show->field('prize_level', __('Prize level'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Prize());

        $form->text('prize_name', __('Prize name'));
        $form->decimal('prize_rand', __('Prize rand'));
        $form->number('prize_num', __('Prize num'));
        $form->number('prize_level', __('Prize level'));

        return $form;
    }
}
