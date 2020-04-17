jQuery(document).ready(function($) { 

    $('.delete-item-btn i, .sbg-delete-all-favorites').on('click', function(e) {
        let action = $(this).data('action');
        let elemId = $(this).parent().data('id'); 
        console.log(action);

        $.ajax({
            type: 'POST',
            url: sbgFavorites.url,
            data: {
                admin_security: sbgFavorites.nonce,
                action: 'sbg_delete_in_dashboard',
                postId: elemId,
                method: action
            },
            beforeSend: function() {
                if(action === 'delete') {
                    $('.sbg-dashboard-favorites-item-' + elemId + ' .hide').fadeOut(300, function() {
                        $('.sbg-favorites-loading-' + elemId).fadeIn();
                    });
                }
                if(action === 'delete-all') {
                    $('.sbg-dashboard-favorites').fadeOut(300, function() {
                        $('img.sbg-favorites-hidden').fadeIn();
                    });
                }
            },
            success: function(res) {
                if(action === 'delete') {
                    $('.sbg-favorites-loading-' + elemId).fadeOut(300, function() {
                    });
                }
                if(action === 'delete-all') {
                    $('img.sbg-favorites-hidden').fadeOut(300, function() {
                        $('.sbg-delete-all-favorites').fadeOut();
                        $('.sbg-delete-all-favorites-block').html('Все записи удалены');
                        $('.sbg-delete-all-favorites-block').css({"fontSize": "15px", "color": "#FF9800", "padding": "0", "border": "none", "margin": "0"});
                    });
                }
            },
            error: function() {
                console.log('Ajax Error')
            }
        });
    });

});