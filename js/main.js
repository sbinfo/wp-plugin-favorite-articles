jQuery(document).ready(function($) {

    $('.sbg-favorites-link a').click(function(e) {
        let action = $(this).data('action');

        $.ajax({
            type: 'POST',
            url: sbgFavorites.url,
            data: {
                security: sbgFavorites.nonce,
                action: 'sbg_change',
                postId: sbgFavorites.postId,
                method: action
            },
            beforeSend: function() {
                $('.sbg-favorites-link a').fadeOut(300, function() {
                    $('.sbg-favorites-loading').fadeIn();
                });
            },
            success: function(res) {
                console.log(res);
                $('.sbg-favorites-loading').fadeOut(300, function() {
                    $('.sbg-favorites-link').html(res);
                    $('.sbg-favorites-link').css({"fontSize": "15px", "color": "#FF9800"});
                });
            },
            error: function() {
                console.log('Error')
            }
        });

        e.preventDefault();
    })
});