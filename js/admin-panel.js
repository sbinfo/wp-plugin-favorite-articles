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
            success: function(res) {
                console.log('succes: ', res);
            },
            error: function() {
                console.log('Ajax Error')
            }
        });
    });

});