$(document).ready(function() {
    // Insert a new chapter
    $(".chapter-insert a").live("click", function() {
        // Chapter ID to insert after
        var chapterId    = $(this).parent().parent().data("chapterid");
        var newChapterId = chapterId + 1;
        
        // Update all of the orders
        $(".chapter").each(function() {
            // Do we need to update this order?
            if ($(this).data("chapterid") > chapterId) {
                // Update this order
                $(this).data("chapterid", (parseInt($(this).data("chapterid")) + 1));
                $(this).attr("id", "chapter-"+$(this).data("chapterid"));
            }
        });
        
        // Insert the chapter
        $.ajax({
            url:  "/ajax/book/"+bookId+"/chapter/insert",
            type: "post",
            data: {
                chapter_id: newChapterId,
            },
            success: function(data) {
                // Add the data
                $("#chapter-"+chapterId).after(data);
                
                // Scroll to it
                var scrollTo = parseInt($("#chapter-"+newChapterId).offset().top) - 100;
                $("html, body").animate({ scrollTop: scrollTo }, 1000);
                
                // And animate it
                $("#chapter-"+newChapterId).animate({ backgroundColor: "#FFFFAA" }, 750)
                                           .animate({ backgroundColor: "#FFFFFF" }, 2000);
                 
                 // Select all the text so the user can start typing straight away
                 $("#chapter-"+newChapterId+" .title").focus();
                 document.execCommand('selectAll', false, null);
            }
        });
        
        // Return
        return false;
    });
    
    // Delete a chapter
    $(".chapter-delete").live("click", function() {
        // Chapter ID
        var chapterId = $(this).parent().data("chapterid");

        // Sure you want to delete this chapter?
        if (confirm("Are you sure you want to remove this chapter?")) {
            // Hide the section interaction
            $("#section-insert").fadeOut(50);

            // And remove
            $.ajax({
                url:  "/ajax/book/"+bookId+"/chapter/delete",
                type: "post",
                data: {
                    chapter_id: chapterId,
                },
                success: function(data) {
                    // Remove the chapter
                    $("body").focus();
                    $("#chapter-"+chapterId).slideUp(750, function() {
                        $(this).remove();
                    });
                }
            });
        }
        
        // Return
        return false;
    });
});