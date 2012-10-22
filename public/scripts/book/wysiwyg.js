$(document).ready(function() {
    // Bold
    $("#wysiwyg-bold").click(function() {
        document.execCommand("bold", null, false);
    });
    // Italic
    $("#wysiwyg-italic").click(function() {
        document.execCommand("italic", null, false);
    });
    // Underline
    $("#wysiwyg-underline").click(function() {
        document.execCommand("underline", null, false);
    });
    // Highlight
    $("#wysiwyg-highlight").click(function() {
        document.execCommand("backColor", null, "#FEEFB3");
    });
    // Remove formatting
    $("#wysiwyg-unformat").click(function() {
        document.execCommand("removeFormat", null, false);
    });
});