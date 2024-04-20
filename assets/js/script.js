;(function($){
    $(document).ready(function(){
        $('#am-refresh-table-block-data').click(function(){
            $('#am-table').html('<h2>Loading......<h2>');
            try {
                jQuery.ajax({
                    url: am_admin_data.ajax_url,
                    data: {
                        action: 'am-refresh-table-data',
                        nonce: am_admin_data.nonce,
                    },
                    type: 'GET',
                    success: function(response) {
                        $('#am-table').html(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }catch(error){
                console.error( 'Error fetching table data', error );
            }
        });
    });
})(jQuery)