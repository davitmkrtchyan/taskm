$(document).ready(function(){
    var alertMsg = $(".alert");

    $("#task-name").focus();

    alertMsg.css("display","block")
        .animate({
        top : "50px"
    }, 1000, "easeInOutQuart");
    setTimeout(function(){
        alertMsg.animate({
            top: "-100px"
        }, 400, "linear")}, 4000);

    $('#publish-article').click(function(){
        $('#preloader-article').css("display", "inline-block");
    });
});