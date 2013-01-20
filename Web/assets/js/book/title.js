$(document).ready(function() {
    // This is a title, we do not want line breaks
    $("#book-title,#book-author,.title").bind('keypress', function(e) {
        if (e.keyCode == 13) {
            e.stopPropagation();
            e.preventDefault();
            return false;
        }
    });
});