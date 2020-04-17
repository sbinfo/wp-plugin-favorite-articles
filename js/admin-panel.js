jQuery(document).ready(function($) { 

    $('.delete-item-btn i').on('click', function(e) {
        let elemId = $(this).parent().data('id'); 
        $.ajax({
            type: 'POST',
            url: sbgFavorites.url,
            data: {
                admin_security: sbgFavorites.nonce,
                action: 'sbg_delete_in_dashboard',
                postId: elemId,
            },
            beforeSend: function() {
                $('.sbg-dashboard-favorites-item-' + elemId + ' .hide').fadeOut(300, function() {
                    $('.sbg-favorites-loading-' + elemId).fadeIn();
                });
            },
            success: function(res) {
                $('.sbg-favorites-loading-' + elemId).fadeOut(300, function() {
                });
            },
            error: function() {
                console.log('Ajax Error')
            }
        });
    });

});