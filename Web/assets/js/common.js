$(document).ready(function() {
    // Load different pages
    $("#navigation .icon").click(function() {
        // Set the loading screen
        setLoading();

        // Set which page we are on
        page = $(this).attr("rel");

        // Is this fullscreen?
        if (page == "fullscreen") {
            page = "book";
        }

        // Send the Ajax request
        $.ajax({
            url: '/book/page/book-id/'+bookId,
            type: 'post',
            data: {
                readonly:    readonly,
                password:    password,
                snapshot_id: snapshotId
            },
            success: function(data) {
                // Set the page
                $("#content").html(data);
            },
            error: function() {
                setError("Sorry, we were unable to load the settings page. Bad times.");
            }
        });
    });

    // Smooth scrolling
    $(function () {
        $('a[href*=#]').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var $target = $(this.hash);
                $target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');
                if ($target.length) {
                    var targetOffset = $target.offset().top;
                    $('html,body').animate({
                        scrollTop: targetOffset
                    }, 1000);
                    return false
                }
            }
        })
    });
});

// Set status indicator
function showStatusIndicator(status) {
    $("#status-indicator").html("<p>"+status+"</p>").fadeIn();
}

// Hide status indicator
function hideStatusIndicator() {
    $("#status-indicator").fadeOut();
}

// Set loading indicator
function setLoading() {
    $("#content").html('<div class="container text-center"><img src="/public/images/loading.gif" alt="" /></div>');
}

// Set error message
function setError(message) {
    $("#content").html('<div class="container text-center"><div class="error"><p>'+message+'</p></div></div>');
}

// Get the range of the text selected
function getRange() {
    // Get the range of the selection
    if (window.getSelection) {
        // Non IE
        savedRange = window.getSelection().getRangeAt(0);
    } else if (document.selection) {
        // IE
        savedRange = document.selection.createRange();
    }

    // And return the selection positions
    return [savedRange.startOffset, savedRange.endOffset];
}