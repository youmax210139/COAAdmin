//手機三條線選單
$(document).ready(function() {
    $("#rwd_nav").click(function() {
        $("#m_nav .bars_close").show();
        $(this).toggleClass("active");
    });
    $("#m_nav .bars_close").click(function() {
        $("#rwd_nav").removeClass("active");
    });
});
//搬移
$(document).ready(function() {
    rwd_fun();
    $(window).resize(rwd_fun);
});

function rwd_fun() {
    var width = window.innerWidth;
    var height = window.innerHeight;
    if (width > 1024) {
        $('#header_nav').before($('#header_logo'));
    } else {
        $('#rwd_nav').before($('#header_logo'));
    }
}

$(document).ready(function(){
    $('#m_nav a').click(function(){
        $("#rwd_nav").removeClass("active");
        $("#m_nav .bars_close").hide();
        $.pageslide.close();
    });
})