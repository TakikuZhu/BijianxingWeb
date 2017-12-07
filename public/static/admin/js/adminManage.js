
function admin_register() {
 
    var reg_id = $("#userid").val();
    var reg_pwd = $("#password").val();
    var reg_pwd2 = $("#password2").val();

    if (reg_id == "") {
        alert("请输入管理员ID");
        $("#userid").focus();
        return false
    }
    if (reg_pwd == "") {
        alert("请输入您的登录密码！");
        $("#password").focus();
        return false
    }
    if (reg_pwd2 == "") {
        alert("请再次输入您的登录密码！");
        $("#password2").focus();
        return false
    }
    if (reg_pwd != reg_pwd2) {
        alert("两次输入的密码不一致！");
        $("#password").focus();
        return false
    }
    $.ajax({
        type: "get",
        url: "addAdmin/",
        eache: false,
        data:{id:reg_id,pwd:reg_pwd},
        success: function(reg) {
           if(reg){
                $("#userid").val("");
                $("#password").val("");
                $("#password2").val("");
                alert("添加成功");
           }else{
                alert("添加失败");
           }
        },
        error: function() {
            alert("服务器发生错误");  
        }
    });
}
function admin_edit() {
 
    var reg_old = $("#passwordold").val();
    var reg_new = $("#passwordnew").val();
    var reg_id = $("#adminid").text();
    var arr = reg_id.split("："); 

    if (reg_old == "") {
        alert("请输入旧的密码");
        $("#userid").focus();
        return false
    }
    if (reg_new == "") {
        alert("请输入新的密码");
        $("#password").focus();
        return false
    }
    $.ajax({
        type: "get",
        url: "editAdmin/",
        eache: false,
        data:{id:arr[1],oldpwd:reg_old,newpwd:reg_new},
        success: function(reg) {
            $("#passwordold").val("");
            $("#passwordnew").val("");
            alert(reg);
        },
        error: function() {
            alert("服务器发生错误"); 
        }
    });
}
function admin_logout() {
    window.location.href = "adminLogout"; //用户
}
