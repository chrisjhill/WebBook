var timeout;
var sectionsChanged = new Array();

$(document).ready(function() {
    // Update automatis saves
    timeout = setTimeout("sectionSave()", 15000);

    // Has a section been updated?
    $(".section").live('focus blur keyup paste', function() {
        // Have we already detected this change?
        if (in_array($(this).data("sectionid"), sectionsChanged)) {
            return false;
        }
        
        // Has changed since last save, need to save again
        sectionsChanged.push($(this).data("sectionid"));
    });
    
    // Mouse up on chapters
    $(".section").live("mouseup update", function(e) {
        // Get the range
        var range = getRange();
        
        // Do we need to show the WYSIWYG?
        if (range[0] !== range[1]) {
            // Show the editor
            // First change it's position
            $("#wysiwyg").css({top: (parseInt(e.clientY) + 20)+"px", left: (parseInt(e.clientX) - 125)+"px"}).fadeIn(250);
        } else {
            // Hide the editor
            $("#wysiwyg").hide();
        }
    });
    
    // Adding a new piece of information
    $(".section:not(.book-title,.book-author span,.chapter-title)").live("mouseenter", function(e) {
        // Where do we need to place the div?
        var offset     = $(this).offset();
        var offsetLeft = offset.left - 70;
        
        // Work out the top offset
        // Title, or content?
        if ($(this).hasClass("title")) {
            // Always display titles in the same place
            var offsetTop  = offset.top - 25;
        } else if ($(this).hasClass("content")) {
            // Content could appear in several places
            // Set variables
            var offsetTop  = e.pageY - 33;
            var offsetMax  = offset.top + (parseInt($(this).height()) - parseInt($("#section-insert").height()));
            
            // Is the top position higher than the offset?
            if (offsetTop > offsetMax) {
                // Too high, move it down
                offsetTop = offsetMax - 7;
            } else if (offsetTop < offset.top) {
                // Too low, move it up
                offsetTop = offset.top + 10;
            } else {
                // Just right, but move it so it is closer to the mouse
                offsetTop = offsetTop + 10;
            }
        }
        
        // Set the section ID
        $(".section-insert-link").data("sectionid", $(this).data("sectionid"));
        
        // And show
        $("#section-insert").hide().delay(300).css({
            top:  offsetTop+"px",
            left: offsetLeft+"px"
        }).fadeIn(750);
    });
    
    // Hide the section insert
    // When focusing on a section
    $(".section").live("click focus", function() {
        $("#section-insert").stop().hide();
    });
    // When leaving the container
    $(".container").live("mouseleave", function() {
        $("#section-insert").stop().fadeOut(1000);
    });
    
    // Insert a new title
    $("#section-insert-title,#section-insert-content").live("click", function() {
        // Section ID to insert after
        var sectionId    = $(this).data("sectionid");
        var sectionType  = $(this).attr("id") == "section-insert-title" ? "subtitle" : "content";
        var chapterId    = $("#section-"+sectionId).data("chapterid");
        var sectionOrder = parseInt($("#section-"+sectionId).data("order")) + 1;
        
        // Update all of the orders
        $("#chapter-"+chapterId+" .section").each(function() {
            // Do we need to update this order?
            if ($(this).data("order") >= sectionOrder) {
                // Update this order
                $(this).data("order", (parseInt($(this).data("order")) + 1));
            }
        });
        
        // Insert the element
        $.ajax({
            url:  "/ajax/book/"+bookId+"/section/insert",
            type: "post",
            data: {
                section_type:      sectionType,
                chapter_id:        chapterId,
                section_order:     sectionOrder
            },
            success: function(data) {
                // Split the data into sections
                var section = data.split("||");
                
                // Add the data
                $("#section-"+sectionId).after(section[1]);
                
                // Scroll to it
                var scrollTo = parseInt($("#section-"+section[0]).offset().top) - 100;
                $("html, body").animate({ scrollTop: scrollTo }, 1000);
                
                // And animate it
                $("#section-"+section[0]).focus()
                                         .animate({ backgroundColor: "#FFFFAA" }, 750)
                                         .animate({ backgroundColor: "#FFFFFF" }, 2000);
                 
                 // Select all the text so the user can start typing straight away
                 document.execCommand('selectAll', false, null);
            }
        });
        
        // Return
        return false;
    });
    
    // Delete a section
    $("#section-insert-delete").live("click", function() {
        // Section ID
        var sectionId = $(this).data("sectionid");

        // Is this a title?
        if ($("#section-"+sectionId).is("h2")) {
            // You cannot delete the chapter title!
            alert("Oh dear! Sorry, you cannot remove chapter titles.");
        } else if (confirm("Are you sure you want to remove this section?")) {
            // Hide the section interaction
            $("#section-insert").fadeOut(500);

            // And remove
            $.ajax({
                url:  "/ajax/book/"+bookId+"/section/delete",
                type: "post",
                data: {
                    section_id: sectionId,
                },
                success: function(data) {
                    // Remove the section
                    $("#section-"+sectionId).slideUp(750, function() {
                        $(this).remove();
                    });
                }
            });
        }
        
        // Return
        return false;
    });
});

// Save the sections that have been updated
function sectionSave() {
    console.log("Saving");
    // Are there any changes needed to be saved?
    if (sectionsChanged.length <= 0) {
        return false;
    }
    
    // @live Set saving indicator
    showStatusIndicator('Saving...');

    // Loop over each section that needs to be saved
    for (var i = 0; i < sectionsChanged.length; i++) {
        // Strip tags
        var wordCount = strip_tags($("#section-"+sectionsChanged[i]).html());
        // Replace multiple spaces with just one
        wordCount = $.trim(wordCount.replace(/\s{2,}/gi, " "));
        // Split on space and get the length
        wordCount = wordCount.split(" ").length;
        
        // And save it
        $.ajax({
            url:  "/ajax/"+page+"/"+bookId+"/section/save",
            type: "post",
            data: {
                section_id:         $("#section-"+sectionsChanged[i]).data("sectionid"),
                section_order:      $("#section-"+sectionsChanged[i]).data("order"),
                section_content:    $("#section-"+sectionsChanged[i]).html(),
                section_word_count: wordCount
            },
            success: function(data) {
                // Save again in another 15 seconds
                clearTimeout(timeout);
                timeout = setTimeout("sectionSave()", 15000);
            }
        });
    }
    
    // And then reset the sections we need to save
    sectionsChanged = new Array();
    
    // And hide status indicator
    hideStatusIndicator('');
}