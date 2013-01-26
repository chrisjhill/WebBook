$(document).ready(function() {
    // We have loaded the book
    // We want to show all, and then gradually hide all
    $("#navigation,#outline").delay(2000).animate({opacity: '0'}, 1000);

    // Hovering over navigation
    $("#navigation").mouseenter(function() {
        $(this).stop(true).animate({opacity: '1'}, 200);
    }).mouseleave(function() {
        if (page == "book") {
            $("#navigation").stop(true).delay(2000).animate({opacity: '0'}, 1000);
        }
    });

    // Hovering over outline
    $("#outline").mouseenter(function() {
        // We only want to show the outline if we are on the book page
        $(this).stop(true).animate({opacity: '1'}, 200);
    }).mouseleave(function() {
        $(this).stop(true).delay(2000).animate({opacity: '0'}, 1000);
    });

    // Fullscreen
    $(".icon-fullscreen").click(function() {
        $("body").fullScreen({'background' : 'url(/public/images/body-bg-wood.jpg) fixed top left'});
    });
});