    $(function () {
        $("#un_reset").on("click", function () {
            $("#uniput").val("");
        })
        $("#uid_reset").on("click", function () {
            $("#uidiput").val("");
        })
        $("#admin_search").on("click", function () {
            if($("#adminse").val().trim()!=""){
                var id = $("#adminse").val().trim();
                $.ajax({
                    type: "get",
                    url: 'getAdmin/'+id,
                    async: true,
                    cache: false,
                    success: function (reg) {
                        if (reg) {
                            $("#adminTable").text("");
                            $('#adminPage').show();
                            $('#adminPage').pagination({
                                totalData:reg.length,
                                showData:5,
                                coping:true,
                                callback:function(api){
                                    $("#adminTable").text("");
                                    var str = "";
                                    for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i=i+3) {

                                        str += "<tr class=''><td class='col-lg-2'>";
                                        str += reg[i].admin_id;
                                        str += "</td><td class='col-lg-1'>";
                                        str += "<a class='admin_delete'>删除</a>"
                                        if(i+1<reg.length){
                                            str += "</td><td class='col-lg-2'>";
                                            str += reg[i+1].admin_id;
                                            str += "</td><td class='col-lg-1'>";
                                            str += "<a class='admin_delete'>删除</a>"
                                            if(i+2<reg.length){
                                                str += "</td><td class='col-lg-2'>";
                                                str += reg[i+2].admin_id;
                                                str += "</td><td class='col-lg-1'>";
                                                str += "<a class='admin_delete'>删除</a>"
                                            }
                                        }

                                        str += "</td></tr>";

                                        

                                    }
                                    $("#adminTable").append(str);


                                }
                            },function(api){
                                $("#adminTable").text("");
                                var str = "";
                                for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i=i+3) {

                                    str += "<tr class=''><td class='col-lg-2'>";
                                    str += reg[i].admin_id;
                                    str += "</td><td class='col-lg-1'>";
                                    str += "<a class='admin_delete'>删除</a>"
                                    if(i+1<reg.length){
                                        str += "</td><td class='col-lg-2'>";
                                        str += reg[i+1].admin_id;
                                        str += "</td><td class='col-lg-1'>";
                                        str += "<a class='admin_delete'>删除</a>"
                                        if(i+2<reg.length){
                                            str += "</td><td class='col-lg-2'>";
                                            str += reg[i+2].admin_id;
                                            str += "</td><td class='col-lg-1'>";
                                            str += "<a class='admin_delete'>删除</a>"
                                        }
                                    }

                                    str += "</td></tr>";

                                    

                                }
                                $("#adminTable").append(str);
                            });

                        }
                        else{
                            alert("没有相关的管理员信息");
                        }
                    }
                })    
            }else{
                $.ajax({
                    type: "get",
                    url: 'getAllAdmin/',
                    async: true,
                    cache: false,
                    success: function (reg) {
                        if (reg) {
                            $("#adminTable").text("");
                            $('#adminPage').show();
                            $('#adminPage').pagination({
                                totalData:reg.length,
                                showData:5,
                                coping:true,
                                callback:function(api){
                                    $("#adminTable").text("");
                                    var str = "";
                                    for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i=i+3) {

                                        str += "<tr class=''><td class='col-lg-2'>";
                                        str += reg[i].admin_id;
                                        str += "</td><td class='col-lg-1'>";
                                        str += "<a class='admin_delete'>删除</a>"
                                        if(i+1<reg.length){
                                            str += "</td><td class='col-lg-2'>";
                                            str += reg[i+1].admin_id;
                                            str += "</td><td class='col-lg-1'>";
                                            str += "<a class='admin_delete'>删除</a>"
                                            if(i+2<reg.length){
                                                str += "</td><td class='col-lg-2'>";
                                                str += reg[i+2].admin_id;
                                                str += "</td><td class='col-lg-1'>";
                                                str += "<a class='admin_delete'>删除</a>"
                                            }
                                        }

                                        str += "</td></tr>";

                                        

                                    }
                                    $("#adminTable").append(str);


                                }
                            },function(api){
                                $("#adminTable").text("");
                                var str = "";
                                for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i=i+3) {

                                    str += "<tr class=''><td class='col-lg-2'>";
                                    str += reg[i].admin_id;
                                    str += "</td><td class='col-lg-1'>";
                                    str += "<a class='admin_delete'>删除</a>"
                                    if(i+1<reg.length){
                                        str += "</td><td class='col-lg-2'>";
                                        str += reg[i+1].admin_id;
                                        str += "</td><td class='col-lg-1'>";
                                        str += "<a class='admin_delete'>删除</a>"
                                        if(i+2<reg.length){
                                            str += "</td><td class='col-lg-2'>";
                                            str += reg[i+2].admin_id;
                                            str += "</td><td class='col-lg-1'>";
                                            str += "<a class='admin_delete'>删除</a>"
                                        }
                                    }

                                    str += "</td></tr>";

                                    

                                }
                                $("#adminTable").append(str);
                            });

                        }
                        else{
                            alert("没有相关的管理员信息");
                        }
                    }
                })    
            }
        })
    $("#unacc_search").on("click", function () {
        if($("#uniput").val().trim()!=""){
            var name = $("#uniput").val().trim();
            $.ajax({
                type: "get",
                url: 'getUserByName/'+'3',
                async: true,
                cache: false,
                data:{da:name},
                success: function (reg) {
                    if (reg) {
                        //reg = eval('(' + reg + ')');
                        $("#userTable").text("");
                        $('#userPage').hide();
                        var str = "";
                        for (var i = 0; i < reg.length; i++) {
                            str += "<tr class=''><td class='col-lg-1'>";
                            str += "<input type='checkbox' name='dyselect' value="+reg[i].user_id+">";
                            str += "</td><td class='col-lg-3'>";
                            str += reg[i].user_name;
                            str += "</td><td class='col-lg-1'>";
                            str += reg[i].user_status;
                            str += "</td><td class='col-lg-1'>";
                            str += reg[i].fans_num;
                            if(reg[i].user_status=="正常"){
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='ice_this'>冻结</a>"
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='ban_this'>禁用</a>"
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='delete_this'>删除</a>"
                                str += "</td></tr>";
                            }
                            else if(reg[i].user_status=="冻结"){
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='unice_this'>解冻</a>"
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='ban_this'>禁用</a>"
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='delete_this'>删除</a>"
                                str += "</td></tr>";
                            }
                            else if(reg[i].user_status=="禁用"){
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='ice_this'>冻结</a>"
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='unban_this'>解禁</a>"
                                str += "</td><td class='col-lg-2'>";
                                str += "<a class='delete_this'>删除</a>"
                                str += "</td></tr>";
                            }
                        }
                        //$(".myTr").remove();
                        $("#userTable").append(str);
                        
                    }
                    else{
                        alert("该用户不存在");
                    }
                }
            })
        }else{
            alert("未填写用户名");
        }
    }

    );
    function getRadioValue(radioName) {
        var chkRadio = document.getElementsByName(radioName);
        for (var i = 0; i < chkRadio.length; i++) {
            if (chkRadio[i].checked)
                return chkRadio[i].value;
        }
    }

    $("#un_search").on("click", function () {
        if($("#uniput").val().trim()!=""){
            var name = $("#uniput").val().trim();
            var chk2 = getRadioValue("ace");
            $.ajax({
                type: "get",
                url: 'getUserByName/'+chk2,
                async: true,
                cache: false,
                data:{da:name},

                success: function (reg) {
                    if (reg) {
                        //reg = eval('(' + reg + ')');
                        $("#userTable").text("");
                        $('#userPage').show();
                        $('#userPage').pagination({
                            totalData:reg.length,
                            showData:5,
                            coping:true,
                            callback:function(api){
                                $("#userTable").text("");
                                var str = "";
                                for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

                                    str += "<tr class=''><td class='col-lg-1'>";
                                    str += "<input type='checkbox' name='dyselect' value="+reg[i].user_id+">";
                                    str += "</td><td class='col-lg-3'>";
                                    str += reg[i].user_name;
                                    str += "</td><td class='col-lg-1'>";
                                    str += reg[i].user_status;
                                    str += "</td><td class='col-lg-1'>";
                                    str += reg[i].fans_num;
                                    if(reg[i].user_status=="正常"){
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='ice_this'>冻结</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='ban_this'>禁用</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='delete_this'>删除</a>"
                                        str += "</td></tr>";
                                    }
                                    else if(reg[i].user_status=="冻结"){
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='unice_this'>解冻</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='ban_this'>禁用</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='delete_this'>删除</a>"
                                        str += "</td></tr>";
                                    }
                                    else if(reg[i].user_status=="禁用"){
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='ice_this'>冻结</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='unban_this'>解禁</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='delete_this'>删除</a>"
                                        str += "</td></tr>";
                                    }
                                    
                                }
                        //$(".myTr").remove();
                        $("#userTable").append(str);
                    }
                },function(api){
                    $("#userTable").text("");

                    var str = "";
                    for (var i = 0; i <5&&i < reg.length; i++) {

                        str += "<tr class=''><td class='col-lg-1'>";
                        str += "<input type='checkbox' name='dyselect' value="+reg[i].user_id+">";
                        str += "</td><td class='col-lg-3'>";
                        str += reg[i].user_name;
                        str += "</td><td class='col-lg-1'>";
                        str += reg[i].user_status;
                        str += "</td><td class='col-lg-1'>";
                        str += reg[i].fans_num;
                        if(reg[i].user_status=="正常"){
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='ice_this'>冻结</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='ban_this'>禁用</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='delete_this'>删除</a>"
                            str += "</td></tr>";
                        }
                        else if(reg[i].user_status=="冻结"){
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='unice_this'>解冻</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='ban_this'>禁用</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='delete_this'>删除</a>"
                            str += "</td></tr>";
                        }
                        else if(reg[i].user_status=="禁用"){
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='ice_this'>冻结</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='unban_this'>解禁</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='delete_this'>删除</a>"
                            str += "</td></tr>";
                        }
                        
                    }
                        //$(".myTr").remove();
                        $("#userTable").append(str);
                    });


}
else{
    alert("该用户不存在");
}
}
})
}else{
    var chk2 = getRadioValue("ace");
    $.ajax({
        type: "get",
        url: 'getAllUser/'+chk2,
        async: true,
        cache: false,

        success: function (reg) {
            if (reg) {

                        //reg = eval('(' + reg + ')');
                        $("#userTable").text("");
                        $('#userPage').show();
                        $('#userPage').pagination({
                            totalData:reg.length,
                            showData:5,
                            coping:true,
                            callback:function(api){
                                $("#userTable").text("");
                                var str = "";
                                for (var i = api.getCurrent()*5-5; i <api.getCurrent()*5&&i < reg.length; i++) {

                                    str += "<tr class=''><td class='col-lg-1'>";
                                    str += "<input type='checkbox' name='dyselect' value="+reg[i].user_id+">";
                                    str += "</td><td class='col-lg-3'>";
                                    str += reg[i].user_name;
                                    str += "</td><td class='col-lg-1'>";
                                    str += reg[i].user_status;
                                    str += "</td><td class='col-lg-1'>";
                                    str += reg[i].fans_num;
                                    if(reg[i].user_status=="正常"){
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='ice_this'>冻结</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='ban_this'>禁用</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='delete_this'>删除</a>"
                                        str += "</td></tr>";
                                    }
                                    else if(reg[i].user_status=="冻结"){
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='unice_this'>解冻</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='ban_this'>禁用</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='delete_this'>删除</a>"
                                        str += "</td></tr>";
                                    }
                                    else if(reg[i].user_status=="禁用"){
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='ice_this'>冻结</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='unban_this'>解禁</a>"
                                        str += "</td><td class='col-lg-2'>";
                                        str += "<a class='delete_this'>删除</a>"
                                        str += "</td></tr>";
                                    }
                                    
                                }
                        //$(".myTr").remove();
                        $("#userTable").append(str);
                    }
                },function(api){
                    $("#userTable").text("");
                    var str = "";
                    for (var i = 0; i <5&&i < reg.length; i++) {

                        str += "<tr class=''><td class='col-lg-1'>";
                        str += "<input type='checkbox' name='dyselect' value="+reg[i].user_id+">";
                        str += "</td><td class='col-lg-3'>";
                        str += reg[i].user_name;
                        str += "</td><td class='col-lg-1'>";
                        str += reg[i].user_status;
                        str += "</td><td class='col-lg-1'>";
                        str += reg[i].fans_num;
                        if(reg[i].user_status=="正常"){
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='ice_this'>冻结</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='ban_this'>禁用</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='delete_this'>删除</a>"
                            str += "</td></tr>";
                        }
                        else if(reg[i].user_status=="冻结"){
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='unice_this'>解冻</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='ban_this'>禁用</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='delete_this'>删除</a>"
                            str += "</td></tr>";
                        }
                        else if(reg[i].user_status=="禁用"){
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='ice_this'>冻结</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='unban_this'>解禁</a>"
                            str += "</td><td class='col-lg-2'>";
                            str += "<a class='delete_this'>删除</a>"
                            str += "</td></tr>";
                        }
                        
                    }
                        //$(".myTr").remove();
                        $("#userTable").append(str);
                    });

}
else{
    alert("搜索失败");
}
}
})
}
}

);
    $(".userMan").delegate(".ban_this", "click", function () {
        var tr = $(this).parent().parent();
        var username = tr.find("td").eq(1).text();
        if(tr.find("td").eq(2).text()=='正常'){
            var r = confirm("确定要禁用该用户吗？")
            if (r == true) {
                $.ajax({
                    type: 'post',
                    url: 'userBan/',
                    data:{da:username},
                    success: function (reg) {
                        tr.find("td").eq(5).find("a").removeClass("ban_this");
                        tr.find("td").eq(5).find("a").addClass("unban_this");
                        tr.find("td").eq(5).find("a").text("解禁");
                        tr.find("td").eq(2).text("禁用");
                        alert(reg);
                    },
                    error: function () {
                        alert("服务器发生错误，用户禁用失败！")
                    }
                });
            }
        }
        else{
            alert("该用户状态为非正常");
        }
    })
    $(".userMan").delegate(".unban_this", "click", function () {
        var tr = $(this).parent().parent();
        var username = tr.find("td").eq(1).text();
        var r = confirm("确定要解禁该用户吗？")
        if (r == true) {
            $.ajax({
                type: 'post',
                url: 'userUnban/',
                data:{da:username},
                success: function (reg) {
                    tr.find("td").eq(5).find("a").removeClass("unban_this");
                    tr.find("td").eq(5).find("a").addClass("ban_this");
                    tr.find("td").eq(5).find("a").text("禁用");
                    tr.find("td").eq(2).text("正常");
                    alert(reg);
                },
                error: function () {
                    alert("服务器发生错误，用户解禁失败！")
                }
            });
        }
    })
    $(".userMan").delegate(".ice_this", "click", function () {
        var tr = $(this).parent().parent();
        var username = tr.find("td").eq(1).text();
        if(tr.find("td").eq(2).text()=='正常'){
            var r = confirm("确定要冻结该用户吗？")
            if (r == true) {
                $.ajax({
                    type: 'post',
                    url: 'UserIce/',
                    data:{da:username},
                    success: function (reg) {
                        tr.find("td").eq(4).find("a").removeClass("ice_this");
                        tr.find("td").eq(4).find("a").addClass("unice_this");
                        tr.find("td").eq(4).find("a").text("解冻");
                        tr.find("td").eq(2).text("冻结");
                        alert(reg);
                    },
                    error: function () {
                        alert("服务器发生错误，用户冻结失败！")
                    }
                });
            }
        }
        else{
            alert("该用户状态为非正常");
        }
    })
    $(".userMan").delegate(".unice_this", "click", function () {
        var tr = $(this).parent().parent();
        var username = tr.find("td").eq(1).text();
        var r = confirm("确定要解冻该用户吗？")
        if (r == true) {
            $.ajax({
                type: 'post',
                url: 'UserUnice/',
                data:{da:username},
                success: function (reg) {
                    tr.find("td").eq(4).find("a").removeClass("unice_this");
                    tr.find("td").eq(4).find("a").addClass("ice_this");
                    tr.find("td").eq(4).find("a").text("冻结");
                    tr.find("td").eq(2).text("正常");
                    alert(reg);
                },
                error: function () {
                    alert("服务器发生错误，用户解冻失败！")
                }
            });
        }
    })
    $(".userMan").delegate(".delete_this", "click", function () {
        var tr = $(this).parent().parent();
        var username = tr.find("td").eq(1).text();
    // if(tr.find("td").eq(2).text()!='删除'){
        var r = confirm("确定要删除该用户吗？")
        if (r == true) {
            $.ajax({
                type: 'post',
                url: 'UserDelete/',
                data:{da:username},
                success: function (reg) {
                // tr.find("td").eq(2).text("已删除");
                tr.remove();
                alert(reg);


            },
            error: function () {
                alert("服务器发生错误，用户删除失败！")
            }
        });
        }

    })
    $(".userMan").delegate(".dydelete", "click", function () {
        var input = $(this).parent().parent().find("input");
        var tr = $(this).parent().parent();
        var dynamicId = input.val();
        var r = confirm("确定要删除该动态吗？")
        if (r == true) {
            $.ajax({
                type: 'post',
                url: 'dynamicDelete/'+dynamicId,
                success: function (reg) {
                    tr.remove();
                    alert(reg);
                },
                error: function () {
                    alert("服务器发生错误，动态删除失败！")
                }
            });
        }
    })
    $(".userMan").delegate(".linktody", "click", function () {
        var input = $(this).parent().parent().find("input");
        var dynamicId = input.val();
        window.open("index/dynamics/index?dynamic_id=" + dynamicId); 
    })
    $(".userMan").delegate(".linktody2", "click", function () {
        var dynamicId = $(this).val();
        window.open("index/dynamics/index?dynamic_id=" + dynamicId); 
    })
    $(".userMan").delegate(".co_delete", "click", function () {
        var input = $(this).parent().parent().find("input");
        var tr = $(this).parent().parent();
        var dynamicId = input.val();
        var r = confirm("确定要删除该评论吗？")
        if (r == true) {
            $.ajax({
                type: 'post',
                url: 'commentsDelete/'+dynamicId,
                success: function (reg) {
                    tr.remove();
                    alert(reg);
                },
                error: function () {
                    alert("服务器发生错误，动态删除失败！")
                }
            });
        }
    })
    $(".userMan").delegate(".admin_delete", "click", function () {
        var td = $(this).parent().parent().find("td");
        var row = $(this).parent().parent().index() + 1; // 行位置
        var col = $(this).parent().index() + 1; // 列位置
        var adminId = td.eq(col-2).text().trim();
        var r = confirm("确定要删除该管理员吗吗？")
        if (r == true) {
            $.ajax({
                type: 'post',
                url: 'adminDelete/'+adminId,
                success: function (reg) {
                    td.eq(col-2).remove();
                    td.eq(col-1).remove();
                    alert(reg);
                },
                error: function () {
                    alert("服务器发生错误，管理员删除失败！")
                }
            });
        }
    })

})
