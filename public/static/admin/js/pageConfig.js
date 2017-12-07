
$(function()
{
         //绑定pagination a  Click事件
        // $(".pagination a").on("click", function() {
        //Click另外一种绑定写法，两种写法的区别可以另外一篇文章《jquery on click绑定事件的区别》
        $(".pagination a").click(function() { 
        	var page = $(this).attr("href");
        	getPage(page);
         //禁止A标签跳转
         return false;
     }) ;

        function getPage(url)
        {
        	$.get(url, function(result){
        //使用jquery html 加载URL
        $("#all").html(result).find("div").eq(2);

    });

        }
    })  
