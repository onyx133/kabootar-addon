<?php ?>
<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="card" style="width:512px">
                    <div class="card-body" style="text-align: center">
                        <p style="font-weight: bold; font-size: 1.2em;
	                     color: #327532">توکن شما با موفقیت ثبت شده است. در این قسمت لازم نیست کاری انجام دهید.
                        </p>
                        <p class="kap_token_preview">
                            توکن شما: <?php echo get_option( '_kap_token', '' ) ?>
                        </p>
                        <div class="card-footer row" style="margin-top: 24px; transition: all 0.4s;
	                    background: inherit;border-top: none; margin-bottom: -24px;">
                            <div class="flex ">
                                <a href="https://safine.net/kabootar"
                                   target="_blank">ورود به ابزار کبوتر</a>
                            </div>
                            <button type="button" class="btn btn-primary btn-lg" id="kap-change-token">تغییر
                                توکن
                            </button>
                            <div></div>
                            <div class="toast " data-autohide="false" style="margin-top: 24px; display:none">
                                <div class="toast-header">
                                    <strong class="mr-auto text-primary">نتیجه درخواست</strong>
                                </div>
                                <div class="toast-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>