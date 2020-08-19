/**
 * Created by Administrator on 2020/8/13 0013.
 */
$(".gocart").click(function() {
    var goods_id = $(this).attr("goods_id");
    $.get(
        "/cart/add",
        {goods_id: goods_id},
        function (res) {
            myAlert("系统提示",res.msg,function(){

            })
        }
    )
})