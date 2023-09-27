<div class="modal fade text-left" id="HotelGroupPopup" tabindex="-1" aria-labelledby="myModalLabel120"
aria-hidden="true" data-backdrop="static">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel120">Add Hotel Group</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <form action="" method="post" id="FrmhotelGroup"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label"
                                    for="basic-addon-name">Group Name <span class="text-danger">*</span></label>
                                <input type="text" id="basic-addon-name"
                                    name="name" class="form-control"
                                    placeholder="Group Name" onkeydown="return /[a-zA-Z ]/.test(event.key)"
                                    value="" aria-describedby="basic-addon-name"
                                    data-error="Group Name" />

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-float waves-light"><span
                                    class="spinner-border spinner-border-sm buttonLoader hide"
                                    role="status" aria-hidden="true"></span><span
                                    class="ml-25 align-middle">{{ __('core.submit') }}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
</div>