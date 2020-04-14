jQuery(document).ready(function($) {

    $('.sbg-favorites-link a').click(function(e) {
        $.ajax({
            type: 'POST',
            url: sbgFavorites.url,
            data: {
                test: 'test query',
                action: 'sbg_test'
            },
            success: function(res) {
                console.log(res);
            },
            error: function() {
                console.log('Error')
            }
        });

        e.preventDefault();
    })
});