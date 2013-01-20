$(document).ready(function() {
    // Select the URL
    $(".url").live("mouseup", function() {
        $(this).select();
    });
    
    // Save the distribution
    $("#distribution-save").live("click", function() {
        // @live Set saving indicator
        showStatusIndicator('Saving...');

        // Send the Ajax request
        $.ajax({
            url:  '/ajax/distribution/'+bookId+'/save/',
            type: 'post',
            data: {
                book_distribution: $("input[name='book_distribution']:checked").val()
            },
            success: function(data) {
                // Display success message
                $("#distribution-status-message").slideUp().html(data).slideDown().delay(5000).slideUp();
                
                // Reload page
                window.location.reload();
            }
        });
        
        // @live Set saving indicator
        hideStatusIndicator('');
        
        // Return
        return false;
    });
});