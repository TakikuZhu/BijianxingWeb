$(document).ready(function () {
    $("#save_btn").on("click", function () {
        var el = document.getElementById("image");
        if (el.files.length <= 0) return;
        var data = new FormData();
        data.append("key", el.files[0]);
        $.ajax({
            url: "../ajax/fileHelper.aspx",
            type: "POST",
            data: data,
            processData: false, //不处理数据
            contentType: false, //不修改MIME类型
            success: function (reg) {
                alert(reg);
            },
            error: function (reg) {
                alert("error");
            }
        })
    })
})
function setIframeHeight(iframe) {
    
    if (iframe) {
        var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
        if (iframeWin.document.body) {
            iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
        }
    }
};