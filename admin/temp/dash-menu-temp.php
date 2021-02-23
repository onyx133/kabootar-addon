<div class="wrap">
    <div class="container">
        <h2>ثبت توکن</h2>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <form action="" id="kap-register-token" class="card was-validated" style="width:512px">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="kap_token"
                                       placeholder="توکنی که از سایت دریافت کردید را وارد کنید" name="kap_token"
                                       required
                                       oninvalid="this.setCustomValidity('لطفا این فیلد را پر کنید')"
                                       oninput="setCustomValidity('')" minlength="10" maxlength="50">
                                <div class="input-group-append">
                                    <span class="input-group-text">توکن</span>
                                </div>
                            </div>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">فیلد ضروری است!</div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit-token">
                            ثبت توکن
                        </button>
                        <div class="toast" data-autohide="false" style="margin-top: 24px; display: none">
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