<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Model\Order;
use App\Model\Goods;
class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Order controller';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);
        $grid->model->orderBy('order_id','desc');
        $grid->column('order_id', __('订单ID'));
        $grid->column('order_no', __('订单号'));
        $grid->column('order.goods_name', __('商品名称'));
        $grid->column('user_id', __('购买人'));
        $grid->column('order_time', __('购买时间'))->display(function($time){
            return date('Y-m-d H:i:s',$time);
        });
        $grid->column('buy_num', __('购买数量'));
        $grid->column("status",__("支付状态"))->display(function($released){
            return $released ? "<font color='green'>已支付</font>" : "<font color='red'>未支付</font>";
        });

        return $grid;
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function creates(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('ID'));
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
        $form = new Form(new Order);

        $form->order_id('id', __('ID'));
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
