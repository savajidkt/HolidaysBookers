@extends('layouts.app')

@section('page_title', 'Hotel Details')

@section('content')

@php

$search_from = date('d/m/Y', strtotime(date('Y-m-d')));

$search_to = date('d/m/Y', strtotime(date('Y-m-d')));

@endphp

@if (isset($requestedArr) && isset($requestedArr['search_from']))

@php

$search_from = $requestedArr['search_from'] ? $requestedArr['search_from'] : date('d/m/Y', strtotime(date('Y-m-d')));

@endphp

@endif

@if (isset($requestedArr) && isset($requestedArr['search_to']))

@php

$search_to = $requestedArr['search_to'] ? $requestedArr['search_to'] : date('d/m/Y', strtotime(date('Y-m-d')));

@endphp

@endif

<script>

   var check_in_startDate = "{!! $search_from !!}";

   var check_in_endDate = "{!! $search_to !!}";

   var filterObj = {};

   filterObj.hotel_amenities = "";

   filterObj.room_amenities = "";

   filterObj.star = "";

   filterObj.price_range = "";

   filterObj.page = 1;

   filterObj.requested_city_id = "{!! $requestedArr['city_id'] ? $requestedArr['city_id'] : '' !!}";

   filterObj.requested_country_id = "{!! $requestedArr['country_id'] ? $requestedArr['country_id'] : '' !!}";

   filterObj.requested_search_from = "{!! $requestedArr['search_from'] ? $requestedArr['search_from'] : '' !!}";

   filterObj.requested_search_to = "{!! $requestedArr['search_to'] ? $requestedArr['search_to'] : '' !!}";

   filterObj.requested_adult = "";

   filterObj.requested_child = "";

   filterObj.requested_room = "";

   filterObj.start_price_range = "";

   filterObj.end_price_range = "";

</script>

<style>

   .button-grid.items-center {

   display: grid;

   grid-template-columns: repeat(4,1fr);

   }

   .col-xl-auto.img-sgl-hb {

    padding: 0;

   }

    a.button.-blue-1.px-24.py-15.bg-white.text-dark-1.js-gallery {

        padding: 0 25px !important;

        height: 45px;

        background-color: #091136 !important;

        color: #fff;

        border-radius: 50px;

    }

    .add-btn {

        display: flex;

        align-items: center;

        gap: 5px;

        width: 100%;

        margin: 0 !important;

        padding: 0 25px;

        height: 45px !important;

        background-color: #091136 !important;

        color: #fff;

        border-radius: 50px;

    }

    button.add-btn:hover {

        background-color: transparent !important;

        border: 1px solid #EE1C25;

        color: #EE1C25 !important;

    }

   

</style>

<div class="header-margin"></div>
<div class="singleMenu js-singleMenu">
   <div class="singleMenu__content">
     <div class="container">
       <div class="row y-gap-20 justify-between items-center">
         <div class="col-auto">
           <div class="singleMenu__links row x-gap-30 y-gap-10">
             <div class="col-auto">
               <a href="#overview">Overview</a>
             </div>
             <div class="col-auto">
               <a href="#rooms">Rooms</a>
             </div>
            
             <div class="col-auto">
               <a href="#facilities">Facilities</a>
             </div>
             <div class="col-auto">
               <a href="#releted">Releted</a>
             </div>
           </div>
         </div>           
       </div>
     </div>
   </div>
 </div>

<section class="hb-single-search-hotal">

   <div class="container">

      <div class=sub-list-hb-single-search-hotal">

         <div class="col-12">

            <form class="" id="SearchFrm" method="get" enctype="multipart/form-data"

               action="{{ route('hotel-list') }}">

               {{-- @csrf --}}

               <div class="mainSearch SearchFrm-result">

                  <div class="button-grid items-center">

                     <div class="pl-20 lg:py-20 lg:px-0 js-form-dd js-liverSearch">

                        <div data-x-dd-click="searchMenu-loc">

                           <h4 class="text-15 fw-500 ls-2 lh-16">Location</h4>

                           <div class="text-15 text-light-1 ls-2 lh-16">

                              <input autocomplete="off" type="search" placeholder="Where are you going?"

                                 class="js-search js-dd-focus" name="location" id="location"

                                 value="{{ isset($requestedArr['location']) ? $requestedArr['location'] : '' }}" />

                              <input type="hidden" class="hidden_city_id" name="city_id"

                                 value="{{ isset($requestedArr['city_id']) ? $requestedArr['city_id'] : '' }}" />

                              <input type="hidden" class="hidden_country_id" name="country_id"

                                 value="{{ isset($requestedArr['country_id']) ? $requestedArr['country_id'] : '' }}" />

                           </div>

                        </div>

                        <div class="searchMenu-loc__field shadow-2 js-popup-window" data-x-dd="searchMenu-loc"

                           data-x-dd-toggle="-is-active">

                           <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">

                              <div class="y-gap-5 js-results">

                                 @if (isset($requestedArr['location']) && strlen($requestedArr['location']) > 0)

                                 <div>

                                    <button type="button"

                                       class="-link d-block col-12 text-left rounded-4 px-20 py-15 js-search-option">

                                       <div class="d-flex">

                                          <div class="icon-location-2 text-light-1 text-20 pt-4">

                                          </div>

                                          <div class="ml-10">

                                             <div

                                                class="text-15 lh-12 fw-500 js-search-option-target">

                                                {{ isset($requestedArr['location']) ? $requestedArr['location'] : '' }}

                                             </div>

                                             <div class="text-14 lh-12 text-light-1 mt-5">

                                                {{ isset($country->name) ? $country->name : '' }}

                                             </div>

                                          </div>

                                       </div>

                                    </button>

                                 </div>

                                 @endif

                              </div>

                           </div>

                        </div>

                     </div>

                     <div class="searchMenu-date px-30 lg:py-20 lg:px-0 js-form-dd js-calendar">

                        <div data-x-dd-click="searchMenu-date">

                           <h4 class="text-15 fw-500 ls-2 lh-16">Check in - Check out</h4>

                           <div class="text-15 text-light-1 ls-2 lh-16">

                              <input class="form-control daterange" placeholder="Check in - Check out"

                                 name="daterange" />

                                 <input type="hidden" id="hidden_from" name="search_from"
                                 value="{{ date('Y-m-d', strtotime(str_replace('/','-',$requestedArr['search_from']))) }}">
                             <input type="hidden" id="hidden_to" name="search_to"
                                 value="{{ date('Y-m-d', strtotime(str_replace('/','-',$requestedArr['search_to']))) }}">

                           </div>

                        </div>

                        <div style="display: none" class="searchMenu-date__field shadow-2"

                           data-x-dd="searchMenu-date" data-x-dd-toggle="-is-active">

                        </div>

                     </div>

                     <div class="searchMenu-guests px-30 lg:py-20 lg:px-0 js-form-dd js-form-counters">

                        <div data-x-dd-click="searchMenu-guests">

                           <h4 class="text-15 fw-500 ls-2 lh-16">Guest</h4>

                           <div class="text-15 text-light-1 ls-2 lh-16" data-x-click="guest">

                              <span

                                 class="js-count-adult">{{ getSearchCookies('searchGuestAdultCount') ? getSearchCookies('searchGuestAdultCount') : 1 }}</span>

                              adults -

                              <span

                                 class="js-count-child">{{ getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0 }}</span>

                              childeren -

                              <span

                                 class="js-count-room">{{ getSearchCookies('searchGuestRoomCount') ? getSearchCookies('searchGuestRoomCount') : 1 }}</span>

                              room

                           </div>

                        </div>

                        <div style="display:none;" class="searchMenu-guests__field shadow-2"

                           data-x-dd="searchMenu-guests" data-x-dd-toggle="-is-active">

                           <div class="bg-white px-30 py-30 rounded-4">

                              <div class="row y-gap-10 justify-between items-center">

                                 <div class="col-auto">

                                    <div class="text-15 fw-500">Adults</div>

                                    <div class="text-14 lh-12 text-light-1 mt-5">(Above 12 Years)</div>

                                 </div>

                                 <div class="col-auto">

                                    <div class="d-flex items-center js-counter"

                                       data-value-change=".js-count-adult">

                                       <button type="button"

                                          class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">

                                       <i class="icon-minus text-12"></i>

                                       </button>

                                       <div class="flex-center size-20 ml-15 mr-15">

                                          <div class="text-15 js-count count-adults">

                                             {{ $requestedArr['adult'] ? $requestedArr['adult'] : 1 }}

                                          </div>

                                       </div>

                                       <button type="button"

                                          class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">

                                       <i class="icon-plus text-12"></i>

                                       </button>

                                    </div>

                                 </div>

                              </div>

                              <div class="border-top-light mt-24 mb-24"></div>

                              <div class="row y-gap-10 justify-between items-center">

                                 <div class="col-auto">

                                    <div class="text-15 lh-12 fw-500">Children</div>

                                    <div class="text-14 lh-12 text-light-1 mt-5">(Age 12 years & below)

                                    </div>

                                 </div>

                                 <div class="col-auto">

                                    <div class="d-flex items-center js-counter"

                                       data-value-change=".js-count-child">

                                       <button type="button"

                                          class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">

                                       <i class="icon-minus text-12"></i>

                                       </button>

                                       <div class="flex-center size-20 ml-15 mr-15">

                                          <div class="text-15 js-count count-childs">

                                             {{ $requestedArr['child'] ? $requestedArr['child'] : 0 }}

                                          </div>

                                       </div>

                                       <button type="button"

                                          class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">

                                       <i class="icon-plus text-12"></i>

                                       </button>

                                    </div>

                                 </div>

                                 <div class="row addChildList">

                                    @if ($requestedArr['child'] == 1)

                                    <div class="col-lg-6">

                                       <label class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Age

                                       of

                                       child

                                       1</label>

                                       <select name="child_age[]" id="child_age">

                                          @php

                                          $optionStr = '';

                                          for ($i = 0; $i <= 12; $i++) {

                                          if (isset($requestedArr['extra_data']['child_age_1']) && $requestedArr['extra_data']['child_age_1'] == $i) {

                                          echo '

                                          <option value="' . $i . '" selected>' . $i . '</option>

                                          ';

                                          } else {

                                          echo '

                                          <option value="' . $i . '">' . $i . '</option>

                                          ';

                                          }

                                          }

                                          @endphp

                                       </select>

                                    </div>

                                    @elseif ($requestedArr['child'] == 2)

                                    <div class="col-lg-6">

                                       <label class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Age

                                       of

                                       child

                                       1</label>

                                       <select name="child_age[]" id="child_age">

                                          @php

                                          $optionStr = '';

                                          for ($i = 0; $i <= 12; $i++) {

                                          if (isset($requestedArr['extra_data']['child_age_1']) && $requestedArr['extra_data']['child_age_1'] == $i) {

                                          echo '

                                          <option value="' . $i . '" selected>' . $i . '</option>

                                          ';

                                          } else {

                                          echo '

                                          <option value="' . $i . '">' . $i . '</option>

                                          ';

                                          }

                                          }

                                          @endphp

                                       </select>

                                    </div>

                                    <div class="col-lg-6">

                                       <label class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Age

                                       of

                                       child

                                       2</label>

                                       <select name="child_age[]" id="child_age">

                                          @php

                                          $optionStr = '';

                                          for ($i = 0; $i <= 12; $i++) {

                                          if (isset($requestedArr['extra_data']['child_age_2']) && $requestedArr['extra_data']['child_age_2'] == $i) {

                                          echo '

                                          <option value="' . $i . '" selected>' . $i . '</option>

                                          ';

                                          } else {

                                          echo '

                                          <option value="' . $i . '">' . $i . '</option>

                                          ';

                                          }

                                          }

                                          @endphp

                                       </select>

                                    </div>

                                    @elseif ($requestedArr['child'] > 2)

                                    <div class="col-lg-6">

                                       <label

                                          class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Younger

                                       Children</label>

                                       <div class="text-14 lh-12 text-light-1 mt-5">Age : 0-6 yrs

                                       </div>

                                       <select name="child_age[]" id="child_age_younger"

                                          class="childMore"

                                          data-child="{{ $requestedArr['child'] }}">

                                          @php

                                          $optionStr = '';

                                          for ($i = 0; $i <= $requestedArr['child']; $i++) {

                                          if (isset($requestedArr['extra_data']['child_younger']) && $requestedArr['extra_data']['child_younger'] == $i) {

                                          echo '

                                          <option value="' . $i . '" selected>' . $i . '</option>

                                          ';

                                          } else {

                                          echo '

                                          <option value="' . $i . '">' . $i . '</option>

                                          ';

                                          }

                                          }

                                          @endphp

                                       </select>

                                    </div>

                                    <div class="col-lg-6">

                                       <label

                                          class="text-16 lh-1 fw-500 text-dark-1 mb-10 mt-40">Older

                                       Children</label>

                                       <div class="text-14 lh-12 text-light-1 mt-5">Age : 7-12 yrs

                                       </div>

                                       <select name="child_age[]" id="child_age_older"

                                          class="childMore"

                                          data-child="{{ $requestedArr['child'] }}">

                                          @php

                                          $optionStr = '';

                                          for ($i = 0; $i <= $requestedArr['child']; $i++) {

                                          if (isset($requestedArr['extra_data']['child_older']) && $requestedArr['extra_data']['child_older'] == $i) {

                                          echo '

                                          <option value="' . $i . '" selected>' . $i . '</option>

                                          ';

                                          } else {

                                          echo '

                                          <option value="' . $i . '">' . $i . '</option>

                                          ';

                                          }

                                          }

                                          @endphp

                                       </select>

                                    </div>

                                    @endif

                                 </div>

                              </div>

                              <div class="border-top-light mt-24 mb-24"></div>

                              <div class="row y-gap-10 justify-between items-center">

                                 <div class="col-auto">

                                    <div class="text-15 fw-500">Rooms</div>

                                 </div>

                                 <div class="col-auto">

                                    <div class="d-flex items-center js-counter"

                                       data-value-change=".js-count-room">

                                       <button type="button"

                                          class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-down">

                                       <i class="icon-minus text-12"></i>

                                       </button>

                                       <div class="flex-center size-20 ml-15 mr-15">

                                          <div class="text-15 js-count count-rooms">

                                             {{ $requestedArr['room'] ? $requestedArr['room'] : 1 }}

                                          </div>

                                       </div>

                                       <button type="button"

                                          class="button -outline-blue-1 text-blue-1 size-38 rounded-4 js-up">

                                       <i class="icon-plus text-12"></i>

                                       </button>

                                    </div>

                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>

                     <div class="button-item">

                        <button

                           class="mainSearch__submit button header-login-btn">

                        <i class="icon-search text-20 mr-10"></i>

                        Search

                        </button>

                     </div>

                  </div>

               </div>

            </form>

         </div>

      </div>

   </div>

</section>

<section class="pt-40">

   <div class="container">

      <div class="hotelSingleGrid">

         <div class="single-hb-page-list">

            <div class="galleryGrid -type-2 pt-40">

               <div class="galleryGrid__item relative d-flex justify-end">

                  @if (strlen($hotelsDetails['hotel']['hotel_image_location']) > 0)

                  <img class="rounded-4"

                     src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/' . $hotelsDetails['hotel']['hotel_image_location'])) }}"

                     alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">

                  @else

                  <img src="{{ asset('assets/front') }}/img/gallery/1/1.png"

                     alt="{{ $hotelsDetails['hotel']['hotel_name'] }}" class="rounded-4">

                  @endif

                  <div class="absolute px-20 py-20">

                     <button class="button -blue-1 size-40 rounded-full bg-white">

                     <i class="icon-heart text-16"></i>

                     </button>

                  </div>

               </div>

               @if (count($hotelsDetails['hotel']['hotel_images']) > 0)

               @php

               $i = 0;

               @endphp

               @foreach ($hotelsDetails['hotel']['hotel_images'] as $key => $img)

               @if ($i == 0 || $i == 1)

               <div class="galleryGrid__item">

                  <img src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/gallery/' . $img['file_path'])) }}"

                     alt="{{ $hotelsDetails['hotel']['hotel_name'] }}" class="rounded-4">

               </div>

               @endif

               @php

               $i++;

               @endphp

               @endforeach

               @endif

               @if (count($hotelsDetails['hotel']['hotel_images']) > 2)

               @php

               $j = 0;

               @endphp

               <div class="galleryGrid__item relative d-flex justify-end items-end">

                  @foreach ($hotelsDetails['hotel']['hotel_images'] as $key => $img)

                  @if ($j == 2)

                  <img src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/gallery/' . $img['file_path'])) }}"

                     alt="{{ $hotelsDetails['hotel']['hotel_name'] }}" class="rounded-4">

                  @endif

                  @php

                  $j++;

                  @endphp

                  @endforeach

                  @php

                  $k = 0;

                  @endphp

                  <div class="absolute px-10 py-10">

                     @foreach ($hotelsDetails['hotel']['hotel_images'] as $key => $img)

                     @if ($k == 3)

                     <a href="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/gallery/' . $img['file_path'])) }}"

                        class="button -blue-1 px-24 py-15 bg-white text-dark-1 js-gallery"

                        data-gallery="gallery2">

                     See All {{ count($hotelsDetails['hotel']['hotel_images']) }} Photos

                     </a>

                     @else

                     <a href="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/gallery/' . $img['file_path'])) }}"

                        class="js-gallery" data-gallery="gallery2"></a>

                     @endif

                     @php

                     $k++;

                     @endphp

                     @endforeach

                  </div>

               </div>

               @endif

            </div>
            <div class="row justify-between">

               <div class="col-auto">

                  <div class="row items-center">

                     <div class="col-auto">

                        <h1 class="text-26 fw-600">{{ $hotelsDetails['hotel']['hotel_name'] }}</h1>

                     </div>

                     @if ($hotelsDetails['hotel']['category'] > 0)

                     <div class="col-auto">

                        @for ($i = 1; $i <= $hotelsDetails['hotel']['category']; $i++)

                        <i class="icon-star text-10 text-yellow-1"></i>

                        @endfor

                     </div>

                     @endif

                  </div>

                  <div class="row x-gap-20 y-gap-20 items-center">

                     <div class="col-auto">

                        <div class="text-15 text-light-1">{{ $hotelsDetails['hotel']['hotel_address'] }}</div>

                     </div>

                  </div>

               </div>

            </div>

            <div id="overview" class="row y-gap-40 pt-40">

               <div class="col-12">

                  <h3 class="text-22 fw-500 pt-40 border-top-light">Overview</h3>

                  <p class="text-dark-1 text-15 mt-20">

                     {!! $hotelsDetails['hotel']['hotel_description'] !!}

                  </p>

               </div>

               @if (count($hotelsDetails['hotel']['hotel_amenities']) > 0)

               <div class="col-12">

                  <h3 class="text-22 fw-500 pt-40 border-top-light">Most Popular Hotel Amenities</h3>

                  <div class="row y-gap-10 pt-20">

                     @foreach ($hotelsDetails['hotel']['hotel_amenities'] as $hotelamenities)

                     <div class="col-md-5">

                        <div class="d-flex x-gap-15 y-gap-15 items-center">

                           <i class="icon-check"></i>

                           <div class="text-15">{{ $hotelamenities['amenity_name'] }}</div>

                        </div>

                     </div>

                     @endforeach

                  </div>

               </div>

               @endif

               @if (count($hotelsDetails['hotel']['hotel_freebies']) > 0)

               <div class="col-12">

                  <h3 class="text-22 fw-500 pt-40 border-top-light">Most Popular Hotel Freebies</h3>

                  <div class="row y-gap-10 pt-20">

                     @foreach ($hotelsDetails['hotel']['hotel_freebies'] as $hotelfreebies)

                     <div class="col-md-5">

                        <div class="d-flex x-gap-15 y-gap-15 items-center">

                           <i class="icon-check"></i>

                           <div class="text-15">{{ $hotelfreebies['name'] }}</div>

                        </div>

                     </div>

                     @endforeach

                  </div>

               </div>

               @endif

            </div>

           

         </div>

         <div>

            <div class="px-30 py-30 border-light rounded-4">

               @if (strlen($hotelsDetails['hotel']['hotel_latitude']) > 0 && strlen($hotelsDetails['hotel']['hotel_longitude']) > 0)

               <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0"

                  marginwidth="0"

                  src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{ $hotelsDetails['hotel']['hotel_latitude'] }},{{ $hotelsDetails['hotel']['hotel_longitude'] }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>

               @endif

            </div>

            <div class="px-30 py-30 border-light rounded-4 mt-30">

               <div class="text-18 fw-500">Hotel Amenities</div>

               <div class="border-top-light mt-20 mb-20"></div>

               <div class="row x-gap-10 y-gap-10">

                  @if ($hotelsDetails['hotel']['hotel_amenities'])

                  <div class="row x-gap-10 y-gap-10 pt-20">

                     @foreach ($hotelsDetails['hotel']['hotel_amenities'] as $amenity)

                     <div class="col-auto">

                        <div class="d-flex items-center py-5 px-20 rounded-100 border-light">

                           <i class="icon-like text-12 text-blue-1 mr-10"></i>

                           <div class="text-14 lh-15">

                              {{ $amenity['amenity_name'] }} <span

                                 class="fw-500 text-blue-1">25</span>

                           </div>

                        </div>

                     </div>

                     @endforeach

                  </div>

                  @endif

               </div>

            </div>

            <div class="px-30 py-30 border-light rounded-4 mt-30">

               <div class="text-18 fw-500">Hotel Freebies</div>

               <div class="border-top-light mt-20 mb-20"></div>

               @if (count($hotelsDetails['hotel']['hotel_freebies']) > 0)                       

               @foreach ($hotelsDetails['hotel']['hotel_freebies'] as $hotelfreebies)

               <div class="row x-gap-20 y-gap-20 ">

                  <div class="col-auto">

                     <div class="text-15"><i class="icon-like text-12 text-blue-1 mr-10"></i> {{ $hotelfreebies['name'] }}</div>

                  </div>

               </div>

               @endforeach

               @endif

            </div>

         </div>

      </div>

   </div>

</section>

<section id="rooms" class="pt-30">
   <div class="container">
     <div class="row pb-20">
       <div class="col-auto">
         <h3 class="text-22 fw-500">Available Rooms</h3>
       </div>
     </div>
     @if (isset($hotelsRoomDetails) && count($hotelsRoomDetails) > 0)
     @foreach ($hotelsRoomDetails as $key => $rooms1)
     <div class="border-light rounded-4 px-30 py-30 sm:px-20 sm:py-20">
       <div class="row y-gap-20">
         <div class="col-12">
           <div class="roomGrid">
             <div class="roomGrid__header">
               <div>{{ $rooms1['room_type'] ? $rooms1['room_type'] : '' }} {{ $rooms1['room_title_with_child'] ? $rooms1['room_title_with_child'] : '' }}</div>               
             </div>
             <div class="roomGrid__grid">
               <div>
                  @if ($rooms1['room_image'])
                 <div class="ratio ratio-1:1">                   
                   <img alt="image" class="img-ratio rounded-4" src="{{ url(Storage::url('app/upload/Hotel/' . $img['hotel_id'] . '/Room/'.$rooms1['room_id'].'/' . $rooms1['room_image'])) }}" alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">
                 </div>
                 @endif
                 @if (count($rooms1['room_amenities']) > 0)
                 <div class="y-gap-5 mt-20">
                  @foreach ($rooms1['room_amenities'] as $roomamenities)
                   <div class="d-flex items-center">
                     <i class="icon-no-smoke text-20 mr-10"></i>
                     <div class="text-15">{{ $roomamenities['amenity_name'] }}</div>
                   </div>
                   @endforeach                  
                 </div>
                 @endif                 
               </div>
               <div class="y-gap-30">
                  @php
                     $offlineRoom = getRoomDetailsByRoomID($rooms1['room_id']);
                  @endphp
                  @foreach ($rooms1['room_price'] as $priceKey=> $roomPrice )
                  @php

                              if (is_array($roomPrice) && count($roomPrice)) {
                                 $bookingParam = [
                                    'is_type' => 'hotel',
                                    'hotel_id' => isset($rooms1['hotel_id']) ? $rooms1['hotel_id'] : '',
                                    'room_id' => isset($rooms1['room_id']) ? $rooms1['room_id'] : '',
                                    'price_id' => isset($roomPrice['price_id']) ? $roomPrice['price_id'] : '',
                                    'adult' => isset($requestParam['adult']) ? $requestParam['adult'] : '',
                                    'child' => isset($requestParam['child']) ? $requestParam['child'] : '',
                                    'room' => isset($requestParam['room']) ? $requestParam['room'] : '',
                                    'city_id' => isset($requestParam['city_id']) ? $requestParam['city_id'] : '',
                                    'search_from' => isset($requestParam['search_from']) ? $requestParam['search_from'] : '',
                                    'search_to' => isset($requestParam['search_to']) ? $requestParam['search_to'] : '',
                                    'originAmount' => isset($roomPrice['originAmount']) ? numberFormat($roomPrice['originAmount']) : '',
                                    'productMarkupAmount' => isset($roomPrice['adminproductMarkupAmount']) ? numberFormat($roomPrice['adminproductMarkupAmount']) : '',
                                    'agentMarkupAmount' => isset($roomPrice['adminagentMarkupAmount']) ? numberFormat($roomPrice['adminagentMarkupAmount']) : '',
                                    'agentGlobalMarkupAmount' => isset($roomPrice['agentMarkupAmount']) ? numberFormat($roomPrice['agentMarkupAmount']) : '',
                                    'finalAmount' => isset($roomPrice['finalAmount']) ? numberFormat($roomPrice['finalAmount']) : '',
                                 ];
                              }

                              $isAddedCart = false;

                     @endphp
                 
                 <div class="roomGrid__content">
                   <div>
                     <div class="text-15 fw-500 mb-10">{{ $roomPrice['meal_plan'] }}:</div>
                   </div>
                   <div>
                      <div class="y-gap-5">
                        <div class="tooltip-trigger-popup">
                           @if($offlineRoom->price[0]->cancelation_policy=='non_refundeble')
                           <div class="tooltip -top px-30 h-50">
                              <i class="fa fa-ban" aria-hidden="true"></i> Non refundable
                              <div class="tooltip__content">Non refundable</div>
                            </div>
                            @endif
                            @if($offlineRoom->price[0]->cancelation_policy=='refundeble')
                                @php
                                $cancellatoin = RoomWiseCancellationPolicy($offlineRoom->price[0],  $bookingParam['search_from']);
                                @endphp
                                <div class="tooltip -top px-30 h-50">
                                    @if($cancellatoin['free'])
                                    <i class="fa fa-ban" aria-hidden="true"></i>Free Cancellation unit <p>{{ $cancellatoin['free'] }}</p>
                                    @else
                                    <i class="fa fa-ban" aria-hidden="true"></i>Non refundable
                                    @endif
                                    <div class="tooltip__content">Cancellation Charges<br>
                                       @if(isset($cancellatoin['charge']))
                                           @foreach ($cancellatoin['charge'] as $cancel )
                                               {{ $cancel['after'] }}  {{ $cancel['charge'] }} <br>
                                           @endforeach
                                       @endif
                                       Date and time is calculated based on local time of destination.
                                   </div>
                                   
                                 </div>           
                            @endif
                        </div>
                     </div>
                   </div>
                   
                   <div>
                     @if (is_array($roomPrice))
                     <div class="text-18 lh-15 fw-500"> {{ getNumberWithCommaGlobalCurrency($roomPrice['finalAmount']) }}  </div> 
                     @endif 
                   </div>                 
                   <div>
                      
                     
                     <button type="button" data-extra="{{ selectRoomBooking($bookingParam, true) }}" class="button SelectRoomBook add-btn">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                         Add
                     <div class="fa fa-spinner fa-spin ml-15" style="display: none;"></div>
                  </button>
                   </div>
                 </div>
                 @endforeach
                 
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
     @endforeach

     @endif
   </div>
 </section>



<div id="facilities"></div>
    <section class="mt-40">
      <div class="container">
        <div class="row x-gap-40 y-gap-40">
          <div class="col-12">
            <h3 class="text-22 fw-500">Facilities of The Crown Hotel</h3>

            <div class="row x-gap-40 y-gap-40 pt-20">
              <div class="col-xl-4">
                <div class="row y-gap-30">
                  <div class="col-12">

                    <div class="">
                      <div class="d-flex items-center text-16 fw-500">
                        <i class="icon-bathtub text-20 mr-10"></i>
                        Bathroom
                      </div>

                      <ul class="text-15 pt-10">

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Towels
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Bath or shower
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Private bathroom
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Toilet
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Free toiletries
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Hairdryer
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Bath
                        </li>

                      </ul>
                    </div>

                  </div>

                  <div class="col-12">

                    <div class="">
                      <div class="d-flex items-center text-16 fw-500">
                        <i class="icon-bed text-20 mr-10"></i>
                        Bedroom
                      </div>

                      <ul class="text-15 pt-10">

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Linen
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Wardrobe or closet
                        </li>

                      </ul>
                    </div>

                  </div>

                  <div class="col-12">

                    <div class="">
                      <div class="d-flex items-center text-16 fw-500">
                        <i class="icon-bell-ring text-20 mr-10"></i>
                        Reception services
                      </div>

                      <ul class="text-15 pt-10">

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Invoice provided
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Private check-in/check-out
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Luggage storage
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          24-hour front desk
                        </li>

                      </ul>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <div class="row y-gap-30">
                  <div class="col-12">

                    <div class="">
                      <div class="d-flex items-center text-16 fw-500">
                        <i class="icon-tv text-20 mr-10"></i>
                        Media &amp; Technology
                      </div>

                      <ul class="text-15 pt-10">

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Flat-screen TV
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Satellite channels
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Radio
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Telephone
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          TV
                        </li>

                      </ul>
                    </div>

                  </div>

                  <div class="col-12">

                    <div class="">
                      <div class="d-flex items-center text-16 fw-500">
                        <i class="icon-juice text-20 mr-10"></i>
                        Food &amp; Drink
                      </div>

                      <ul class="text-15 pt-10">

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Kid meals
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Special diet menus (on request)
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Breakfast in the room
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Bar
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Restaurant
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Tea/Coffee maker
                        </li>

                      </ul>
                    </div>

                  </div>

                  <div class="col-12">

                    <div class="">
                      <div class="d-flex items-center text-16 fw-500">
                        <i class="icon-washing-machine text-20 mr-10"></i>
                        Cleaning services
                      </div>

                      <ul class="text-15 pt-10">

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Daily housekeeping
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Dry cleaning
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Laundry
                        </li>

                      </ul>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <div class="row y-gap-30">
                  <div class="col-12">

                    <div class="">
                      <div class="d-flex items-center text-16 fw-500">
                        <i class="icon-shield text-20 mr-10"></i>
                        Safety &amp; security
                      </div>

                      <ul class="text-15 pt-10">

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Fire extinguishers
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          CCTV in common areas
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Smoke alarms
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          24-hour security
                        </li>

                      </ul>
                    </div>

                  </div>

                  <div class="col-12">

                    <div class="">
                      <div class="d-flex items-center text-16 fw-500">
                        <i class="icon-city-2 text-20 mr-10"></i>
                        General
                      </div>

                      <ul class="text-15 pt-10">

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Hypoallergenic
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Non-smoking throughout
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Wake-up service
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Heating
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Packed lunches
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Carpeted
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Lift
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Fan
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Family rooms
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Facilities for disabled guests
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Ironing facilities
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Non-smoking rooms
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Iron
                        </li>

                        <li class="d-flex items-center">
                          <i class="icon-check text-10 mr-20"></i>
                          Room service
                        </li>

                      </ul>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div id="releted"></div>
<section class="layout-pt-md layout-pb-lg">

   <div class="container">

      <div class="row justify-center text-center">

         <div class="col-auto">

            <div class="sectionTitle -md">

               <h2 class="sectionTitle__title">Popular properties similar to The Crown Hotel</h2>

               <p class=" sectionTitle__text mt-5 sm:mt-0">Interdum et malesuada fames ac ante ipsum</p>

            </div>

         </div>

      </div>

      <div class="row y-gap-30 pt-40 sm:pt-20">

         @if (count($hotelsRelated) > 0)

         @foreach ($hotelsRelated as $key => $value)

         <div class="col-xl-3 col-lg-3 col-sm-6">

            <a href="{{ route('hotel-details', $safeencryptionObj->encode($value['id'])) }}"

               class="hotelsCard -type-1 ">

               <div class="hotelsCard__image">

                  <div class="cardImage ratio ratio-1:1">

                     <div class="cardImage__content">

                        @if (count($value['hotel_images']) > 0)

                        <div

                           class="cardImage-slider rounded-4 overflow-hidden js-cardImage-slider">

                           <div class="swiper-wrapper">

                              @foreach ($value['hotel_images'] as $key => $img)

                              <div class="swiper-slide">

                                 <img class="col-12"

                                    src="{{ url(Storage::url('app/upload/Hotel/' . $img['hotel_id'] . '/gallery/' . $img['file_path'])) }}"

                                    alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">

                              </div>

                              @endforeach

                           </div>

                           <div class="cardImage-slider__pagination js-pagination"></div>

                           <div class="cardImage-slider__nav -prev">

                              <button

                                 class="button -blue-1 bg-white size-30 rounded-full shadow-2 js-prev">

                              <i class="icon-chevron-left text-10"></i>

                              </button>

                           </div>

                           <div class="cardImage-slider__nav -next">

                              <button

                                 class="button -blue-1 bg-white size-30 rounded-full shadow-2 js-next">

                              <i class="icon-chevron-right text-10"></i>

                              </button>

                           </div>

                        </div>

                        @else

                        @if (strlen($hotelsDetails['hotel']['hotel_image_location']) > 0)

                        <img class="rounded-4 col-12"

                           src="{{ url(Storage::url('app/upload/Hotel/' . $hotelsDetails['hotel']['id'] . '/' . $hotelsDetails['hotel']['hotel_image_location'])) }}"

                           alt="{{ $hotelsDetails['hotel']['hotel_name'] }}">

                        @else

                        <img src="{{ asset('assets/front') }}/img/gallery/1/1.png"

                           alt="{{ $hotelsDetails['hotel']['hotel_name'] }}"

                           class="rounded-4 col-12">

                        @endif

                        @endif

                     </div>

                     <div class="cardImage__wishlist">

                        <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">

                        <i class="icon-heart text-12"></i>

                        </button>

                     </div>

                     <div class="cardImage__leftBadge">

                        <div

                           class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-dark-1 text-white">

                           Breakfast included

                        </div>

                     </div>

                  </div>

               </div>

               <div class="hotelsCard__content mt-10">

                  <h4 class="hotelsCard__title text-dark-1 text-18 lh-16 fw-500">

                     <span>{{ $value['hotel_name'] }}</span>

                  </h4>

                  <p class="text-light-1 lh-14 text-14 mt-5">{{ $value['hotel_address'] }}</p>

                  <div class="d-flex items-center mt-20">

                     <div class="flex-center bg-blue-1 rounded-4 size-30 text-12 fw-600 text-white">

                        {{ $value['hotel_review'] }}

                     </div>

                     <div class="text-14 text-dark-1 fw-500 ml-10">Exceptional</div>

                     <div class="text-14 text-light-1 ml-10">3,014 reviews</div>

                  </div>

                  @if (isset($value['room']['price']))

                  <div class="mt-5">

                     <div class="fw-500">

                        Starting from <span

                           class="text-blue-1">{{ isset($value['room']['price']) ? $value['room']['price'] : '' }}</span>

                     </div>

                  </div>

                  @endif

               </div>

            </a>

         </div>

         @endforeach

         @endif

      </div>

   </div>

</section>

<section class="layout-pt-md layout-pb-md bg-dark-2">

   <div class="container">

      <div class="row y-gap-30 justify-between items-center">

         <div class="col-auto">

            <div class="row y-gap-20  flex-wrap items-center">

               <div class="col-auto">

                  <div class="icon-newsletter text-60 sm:text-40 text-white"></div>

               </div>

               <div class="col-auto">

                  <h4 class="text-26 text-white fw-600">Your Travel Journey Starts Here</h4>

                  <div class="text-white">Sign up and we'll send the best deals to you</div>

               </div>

            </div>

         </div>

         <div class="col-auto">

            <div class="single-field -w-410 d-flex x-gap-10 y-gap-20">

               <div>

                  <input class="bg-white h-60" type="text" placeholder="Your Email">

               </div>

               <div>

                  <button class="button -md h-60 bg-blue-1 text-white">Subscribe</button>

               </div>

            </div>

         </div>

      </div>

   </div>

</section>

@endsection

@section('page-script')

<script src="{{ asset('assets/front/js/code.jquery.com_jquery-3.6.0.js') }}"></script>

<script src="{{ asset('assets/front/js/cdn.jsdelivr.net_momentjs_latest_moment.min.js') }}"></script>

<script src="{{ asset('assets/front/js/cdn.jsdelivr.net_npm_daterangepicker_daterangepicker.min.js') }}"></script>

<script src="{{ asset('assets/front/js/code.jquery.com_ui_1.13.2_jquery-ui.js') }}"></script>

<script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>

<script src="{{ asset('assets/front/js/search-form/Search.js') }}"></script>

<script src="{{ asset('assets/front/js/sweet-alert.min.js') }}"></script>

<script src="{{ asset('assets/front/js/search-form/Currencies.js') }}"></script> 

<script type="text/javascript">

   var moduleConfig = {

       searchLocationByName: "{!! route('city-hotel-list') !!}",

       addedToCartBooking: "{!! route('ajax-temp-store') !!}",

       removeToCartBooking: "{!! route('ajax-temp-remove') !!}",

   };

</script>

@endsection