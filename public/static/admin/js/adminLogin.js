function admin_login() {
    var user_uname = $("#userid").val();
    var user_psw = $("#password").val();

    if (user_uname == "") {
        alert("请输入您账号");
        $("#userid").focus();
        return false
    }
    if (user_psw == "") {
        alert("请输入您的密码");
        $("#password").focus();
        return false
    }

    $.ajax({
        type: "get",
        url: 'checkAdmin/',
        data:{id:user_uname,pwd:user_psw},
        eache: false,
        success: function (reg) {
            if(reg==100){
                alert("账号不存在");
            }
            else if(reg==101){
                alert("密码错误");
            }
            else{
                window.location.href = "admin"; //用户
            }

        },
        error: function() {
            alert("服务器发生错误");  
        }
    });
}
function admin_logout() {
    window.location.href = "adminLogout"; //用户
}


