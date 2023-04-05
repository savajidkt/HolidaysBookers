@if ($hotelRooms->count() > 0)

    @foreach ($hotelRooms as $room)
        <div class="row">
            <div class="col-xl">
                <div class="bg-white rounded-4 ">
                    <div class="row">
                        <div class="col-lg col-md-6">
                            <div class="text-15 fw-500 ">Junior leisure suite twin</div>
                            <div class="">
                                <div class="d-flex items-center text-green-2">
                                    <i class="icon-check text-14 mr-10"></i>
                                    <div class="text-14 text-green-2 lh-15">Pay at the hotel</div>
                                </div>
                                <div class="d-flex items-center text-green-2">
                                    <i class="icon-check text-12 mr-10"></i>
                                    <div class="text-14 text-green-2 lh-15 ">Pay nothing until March 30, 2022</div>
                                </div>
                                <div class="d-flex items-center text-green-2">
                                    <i class="icon-check text-12 mr-10"></i>
                                    <div class="text-14 text-green-2 lh-15 ">Free cancellation before April 1, 2022
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-auto col-md-6 border-left-light lg:border-none text-right lg:text-left">
                            <div class="pl-40 lg:pl-0">
                                <div class="text-14 lh-14 text-light-1 mb-5">3 rooms for</div>
                                <div class="text-20 lh-14 fw-500">US$72</div>
                                <a href="#" class="button h-50 px-35 -dark-1 bg-blue-1 text-white mt-10">
                                    Add 
                                    <div class="icon-arrow-top-right ml-15">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="accordion__item px-20 py-20 border-light rounded-4 is-active">
        <div class="accordion__button d-flex items-center">
            <div class="button text-dark-1">No room found!</div>
        </div>
    </div>
@endif
