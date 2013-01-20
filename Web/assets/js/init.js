$(document).ready(function() {
    // Okay, load page we want initialls
    var pageToLoad = "book";
    if (window.location.hash) {
        pageToLoad = window.location.hash.replace("#", "");
    }

    // If we are loading a snapshot, only show the book
    if (readonly) {
        // Load book
        pageToLoad = "book";

        // Hide the navigation
        $("#navigation").hide();
    }

    // And click the link
    $("#navigation a[rel='"+pageToLoad+"']").click();

    // Which sections to hide?
    if (pageToLoad == "book") {
        // We have loaded the book
        // We want to show all, and then gradually hide all
        $("#navigation,#outline").delay(2000).animate({opacity: '0'}, 1000);
    } else {
        // We are not on the book page
        // We want to the navigation
        // We want to hide the outline instantly as it's not relevant
        $("#outline").css("opacity", "0");
    }

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