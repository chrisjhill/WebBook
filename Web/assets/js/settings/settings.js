$(document).ready(function() {
    // Save the settings
    $("#settings-save").live("click", function() {
        // @live Set saving indicator
        showStatusIndicator('Saving...');

        // Send the Ajax request
        $.ajax({
            url:  '/ajax/settings/'+bookId+'/save/',
            type: 'post',
            data: {
                setting_autosave:         $("#setting_autosave").val(),
                setting_font_family:      $("#setting_font_family").val(),
                setting_font_size:        $("#setting_font_size").val(),
                setting_font_color:       $("#setting_font_color").val(),
                setting_line_height:      $("#setting_line_height").val(),
                setting_alignment:        $("#setting_alignment").val(),
                setting_background:       $("#setting_background").val(),
                setting_page_paddings:    $("#setting_page_paddings").val(),
                setting_display_comments: $("#setting_display_comments").val()
            },
            success: function(data) {
                // Display success message
                $("#settings-status-message").slideUp().html(data).slideDown().delay(5000).slideUp();
                
                // Reload the stylesheet
                var customStyle = $("#custom-styles").attr("href");
                customStyle = customStyle.split("?");
                $("#custom-styles").attr("href", customStyle[0]+"?time="+new Date().getTime());
            }
        });
        
        // @live Set saving indicator
        hideStatusIndicator('');
        
        // Return
        return false;
    });
});