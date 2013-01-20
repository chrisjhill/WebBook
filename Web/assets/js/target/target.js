$(document).ready(function() {
    // Save the target
    $("#target-save").live("click", function() {
        // @live Set saving indicator
        showStatusIndicator('Saving...');

        // Send the Ajax request
        $.ajax({
            url:  '/ajax/target/'+bookId+'/save/',
            type: 'post',
            data: {
                target_word_count: $("#target_word_count").val(),
                target_date:       $("#target_date").val()
            },
            success: function(data) {
                // @live Set saving indicator
                hideStatusIndicator('');
            }
        });
        
        // Return
        return false;
    });
});