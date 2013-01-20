$(document).ready(function() {
    // Show plus sign for each chapter that has subtitles
    $("#outline > ul > li").has("ul").each(function() {
        // Add a plus after the link
        $("> a", this).before('<a href="#" class="outline-expand">+</a> ');
    });
    
    // Show the rest of the subtitles
    $(".outline-expand").live("click", function() {
        // Show, or hide?
        if ($(this).html() == " - ") {
            $(this).html("+ ");
            $(this).parent().find("ul").slideUp();
        } else {
            $(this).html(" - ");
            $(this).parent().find("ul").slideDown();
        }
        return false;
    });
});