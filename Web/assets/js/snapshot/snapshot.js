$(document).ready(function() {
    // Save the snapshot
    $("#snapshot-save").live("click", function() {
        // @live Set saving indicator
        showStatusIndicator('Saving...');

        // Send the Ajax request
        $.ajax({
            url:  '/ajax/snapshot/'+bookId+'/save/',
            type: 'post',
            success: function(data) {
                // Display success message
                $("#snapshot-status-message").slideUp().html(data).slideDown().delay(5000).slideUp();
                
                // @live Set saving indicator
                hideStatusIndicator('');
                
                // Reload page
                window.location.reload();
            }
        });
        
        // Return
        return false;
    });
    
    // Remove a snapshot
    $(".snapshot-remove").live("click", function() {
        // Sure?
        if (confirm("Are you sure you want to delete this snapshot?")) {
            // The snapshot ID
            var snapshotId = $(this).data("snapshotid");
            
            // Send the Ajax request
            $.ajax({
                url:  '/ajax/snapshot/'+bookId+'/delete/',
                type: 'post',
                data: {
                    snapshot_id: snapshotId
                },
                success: function(data) {
                    // Hide the table cell
                    $("#snapshot-"+snapshotId).fadeOut(800);
                }
            });
        }
        
        // Return
        return false;
    });
});