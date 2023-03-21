<div class="modal fade text-left" id="roomAmenityBTN" tabindex="-1" aria-labelledby="myModalLabel120"
aria-hidden="true" data-backdrop="static">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel120">Add Hotel Freebies</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <form action="" method="post" id="FrmhotelAmenity"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label"
                                    for="basic-addon-amenity_name">Freebies Name</label>
                                <input type="text" id="basic-addon-amenity_name"
                                    name="amenity_name" class="form-control"
                                    placeholder="Freebies Name"
                                    value="" aria-describedby="basic-addon-amenity_name"
                                    data-error="Freebies Name" />
                                <input type="hidden" name="type" id="type" value="1">

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