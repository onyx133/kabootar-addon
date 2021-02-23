jQuery(document).ready(function ($) {
    $('.kap-response').hide();
    $('#kap-register-token').submit(function (e) {
        e.preventDefault();
        $('.btn-submit-token').html('ثبت توکن <span class="spinner-border spinner-border-sm mr-2" ' +
            'role="status" aria-hidden="true" style="margin-bottom: 5px; margin-right: 2px;"></span>')
            .attr('disabled', true);
        const token = $('#kap_token').val();
        const data = {
            action: 'register_token',
            nonce: kap_object.nonce,
            token: token,
        };
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: kap_object.ajax_url,
            data: data,
            success: function (response) {
                $('.btn-submit-token').html('تغییر توکن')
                    .attr('disabled', false);
                if (response.code === '110') {
                    $('.toast').show();
                    $('.toast').toast('show');
                    $('.toast-body').text('توکن شما با موفقیت ثبت شد.')

                    setTimeout(hideResponse, 3000);
                    function hideResponse() {
                        $('.toast').toast('hide');
                        location.reload();
                    }
                }
            }, error: function (error) {
                $('.btn-submit-token').html('تغییر توکن')
                    .attr('disabled', false);
                console.log(error);
            }
        });
    });
    $('#kap-change-token').on('click', function (e) {
        e.preventDefault();
        $('#kap-change-token').html('لطفا منتظر بمانید <span class="spinner-border spinner-border-sm mr-2" ' +
            'role="status" aria-hidden="true" style="margin-bottom: 8px; margin-left: 8px;"></span>')
            .attr('disabled', true);
        const data = {
            action: 'change_token',
            nonce: kap_object.nonce,
        };
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: kap_object.ajax_url,
            data: data,
            success: function (response) {
                $('#kap-change-token').html('تغییر توکن')
                    .attr('disabled', false);
                if (response.code === '110') {
                    $('.toast').show();
                    $('.toast').toast('show');
                    $('.toast-body').text('لطفا منتظر بمانید تا به صفحه تغییر توکن انتقال داده شوید...')

                    setTimeout(hideResponse, 2000);
                    function hideResponse() {
                        $('.toast').toast('hide');
                        location.reload();
                    }
                }
            }, error: function (error) {
                $('#kap-change-token').html('تغییر توکن')
                    .attr('disabled', false);
                console.log(error);
            }
        });

    })
})