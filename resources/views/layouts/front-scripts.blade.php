<div class="langMenu is-hidden js-langMenu guestModal" data-x="guest" data-x-toggle="is-hidden">
    <div class="langMenu__bg" data-x-click="guest"></div>

    <div class="langMenu__content bg-white rounded-4">
        <div class="d-flex items-center justify-between px-30 py-20 sm:px-15 border-bottom-light">
            <div class="text-20 fw-500 lh-15">Select guest</div>
            <button class="pointer" data-x-click="guest">
                <i class="icon-close"></i>
            </button>
        </div>

        <div class=" px-30 py-5 sm:px-15 sm:py-15">

            @if (is_array(getSearchCookies('searchGuestArr')) && count(getSearchCookies('searchGuestArr')) > 0)
                @php
                    $i = 0;
                @endphp
                @foreach (getSearchCookies('searchGuestArr') as $guest)
                    @php
                        $i++;
                    @endphp
                    <div class="row optionBox">
                        <div class="col-lg-6 ddynamicChilds">
                            <div class="col-lg-2  py-20">
                                @if ($i == 1)
                                    <div class="accordion__icon size-40 flex-center rounded-full mr-20">
                                    </div>
                                @else
                                    <div class="accordion__icon size-40 flex-center bg-error-1 rounded-full mr-20 remove"
                                        data-action="remove">
                                        <i class="icon-minus"></i>
                                    </div>
                                @endif

                            </div>
                            <div class="col-lg-3 text-center">
                                <div class="fw-500 mb-4">Room</div>
                                <div class="">
                                    <label
                                        class="lh-1 text-16 fw-500 text-dark-1 roomNumber">{{ $guest->room }}</label>
                                </div>
                            </div>
                            <div class="col-lg-3 text-center">
                                <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Adult</label>
                                <select name="adult" id="adult" class="adult text-center">
                                    <option value="1" {{ $guest->adult == 1 ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $guest->adult == 2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $guest->adult == 3 ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $guest->adult == 4 ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ $guest->adult == 5 ? 'selected' : '' }}>5</option>
                                    <option value="6" {{ $guest->adult == 6 ? 'selected' : '' }}>6</option>
                                </select>
                            </div>
                            <div class="col-lg-3 text-center">
                                <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Child</label>
                                <select name="child" id="child" class="addDynamicChilds text-center child">
                                    <option value="0" {{ $guest->child == 0 ? 'selected' : '' }}>0</option>
                                    <option value="1" {{ $guest->child == 1 ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $guest->child == 2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $guest->child == 3 ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ $guest->child == 4 ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ $guest->child == 5 ? 'selected' : '' }}>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="dynamicChilds col-lg-6 text-center">
                            @if (is_array($guest->childAge) && count($guest->childAge) > 0)
                                @foreach ($guest->childAge as $key => $childAge)
                                    
                                    <div class="col-lg-2 agess">
                                        <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Age</label>
                                        <select name="age" id="age" class="age text-center">
                                            <option value="2" {{ $childAge->age == 2 ? 'selected' : '' }}>2
                                            </option>
                                            <option value="3" {{ $childAge->age == 3 ? 'selected' : '' }}>3
                                            </option>
                                            <option value="4" {{ $childAge->age == 4 ? 'selected' : '' }}>4
                                            </option>
                                            <option value="5" {{ $childAge->age == 5 ? 'selected' : '' }}>5
                                            </option>
                                            <option value="6" {{ $childAge->age == 6 ? 'selected' : '' }}>6
                                            </option>
                                            <option value="7" {{ $childAge->age == 7 ? 'selected' : '' }}>7
                                            </option>
                                            <option value="8" {{ $childAge->age == 8 ? 'selected' : '' }}>8
                                            </option>
                                            <option value="9" {{ $childAge->age == 9 ? 'selected' : '' }}>9
                                            </option>
                                            <option value="10" {{ $childAge->age == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="11" {{ $childAge->age == 11 ? 'selected' : '' }}>11
                                            </option>
                                        </select>

                                        <div class="d-flex px-5 py-5 ageCWBCHK {{ $childAge->age > 2 ? 'is-show' : 'is-hide' }} ">
                                            <div class="form-checkbox ">
                                                <input type="checkbox" name="ageCWB" class="ageCWB"
                                                    {{ $childAge->cwb == 'yes' ? 'checked' : '' }}>
                                                <div class="form-checkbox__mark">
                                                    <div class="form-checkbox__icon icon-check"></div>
                                                </div>
                                            </div>
                                            <div class="text-14 lh-12 ml-10">CWB</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>
                    </div>
                @endforeach
            @else
                <div class="row optionBox">
                    <div class="col-lg-6 ddynamicChilds">
                        <div class="col-lg-2  py-20">
                            <div class="accordion__icon size-40 flex-center rounded-full mr-20">

                            </div>
                        </div>
                        <div class="col-lg-3 text-center">
                            <div class="fw-500 mb-4">Room</div>
                            <div class="">
                                <label class="lh-1 text-16 fw-500 text-dark-1 roomNumber">1</label>
                            </div>
                        </div>
                        <div class="col-lg-3 text-center">
                            <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Adult</label>
                            <select name="adult" id="adult" class="adult text-center">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <div class="col-lg-3 text-center">
                            <label class="text-16 lh-1 fw-500 text-dark-1 mb-10">Child</label>
                            <select name="child" id="child" class="addDynamicChilds text-center child">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="dynamicChilds col-lg-6 text-center">
                    </div>
                    <hr>
                </div>
            @endif
            <div class="row py-30 sm:px-15 sm:py-15 row-block">
                <div class="col-lg-6">
                    <div class="accordion__icon size-40 flex-center bg-success-1 rounded-full mr-20 addMore"
                        data-action="add">
                        <i class="icon-plus"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion__icon size-40 flex-center bg-success-1 rounded-full mr-20 SearchDone floatright"
                        data-action="add">
                        <i class="icon-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="langMenu is-hidden js-langMenu" data-x="lang" data-x-toggle="is-hidden">
    <div class="langMenu__bg" data-x-click="lang"></div>

    <div class="langMenu__content bg-white rounded-4">
        <div class="d-flex items-center justify-between px-30 py-20 sm:px-15 border-bottom-light">
            <div class="text-20 fw-500 lh-15">Select your language</div>
            <button class="pointer" data-x-click="lang">
                <i class="icon-close"></i>
            </button>
        </div>

        <div class="modalGrid px-30 py-30 sm:px-15 sm:py-15">

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">English</div>
                    <div class="text-14 lh-15 mt-5 js-title">United States</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Türkçe</div>
                    <div class="text-14 lh-15 mt-5 js-title">Turkey</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Español</div>
                    <div class="text-14 lh-15 mt-5 js-title">España</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Français</div>
                    <div class="text-14 lh-15 mt-5 js-title">France</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Italiano</div>
                    <div class="text-14 lh-15 mt-5 js-title">Italia</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">English</div>
                    <div class="text-14 lh-15 mt-5 js-title">United States</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Türkçe</div>
                    <div class="text-14 lh-15 mt-5 js-title">Turkey</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Español</div>
                    <div class="text-14 lh-15 mt-5 js-title">España</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Français</div>
                    <div class="text-14 lh-15 mt-5 js-title">France</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Italiano</div>
                    <div class="text-14 lh-15 mt-5 js-title">Italia</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">English</div>
                    <div class="text-14 lh-15 mt-5 js-title">United States</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Türkçe</div>
                    <div class="text-14 lh-15 mt-5 js-title">Turkey</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Español</div>
                    <div class="text-14 lh-15 mt-5 js-title">España</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Français</div>
                    <div class="text-14 lh-15 mt-5 js-title">France</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Italiano</div>
                    <div class="text-14 lh-15 mt-5 js-title">Italia</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">English</div>
                    <div class="text-14 lh-15 mt-5 js-title">United States</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Türkçe</div>
                    <div class="text-14 lh-15 mt-5 js-title">Turkey</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Español</div>
                    <div class="text-14 lh-15 mt-5 js-title">España</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Français</div>
                    <div class="text-14 lh-15 mt-5 js-title">France</div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Italiano</div>
                    <div class="text-14 lh-15 mt-5 js-title">Italia</div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="currencyMenu is-hidden js-currencyMenu" data-x="currency" data-x-toggle="is-hidden">
    <div class="currencyMenu__bg" data-x-click="currency"></div>

    <div class="currencyMenu__content bg-white rounded-4">
        <div class="d-flex items-center justify-between px-30 py-20 sm:px-15 border-bottom-light">
            <div class="text-20 fw-500 lh-15">Select your currency</div>
            <button class="pointer" data-x-click="currency">
                <i class="icon-close"></i>
            </button>
        </div>

        <div class="modalGrid px-30 py-30 sm:px-15 sm:py-15">

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">United States dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">USD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Australian dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">AUD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Brazilian real</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">BRL</span>
                        - R$
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Bulgarian lev</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">BGN</span>
                        - лв.
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Canadian dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">CAD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">United States dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">USD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Australian dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">AUD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Brazilian real</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">BRL</span>
                        - R$
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Bulgarian lev</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">BGN</span>
                        - лв.
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Canadian dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">CAD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">United States dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">USD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Australian dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">AUD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Brazilian real</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">BRL</span>
                        - R$
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Bulgarian lev</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">BGN</span>
                        - лв.
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Canadian dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">CAD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">United States dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">USD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Australian dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">AUD</span>
                        - $
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Brazilian real</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">BRL</span>
                        - R$
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Bulgarian lev</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">BGN</span>
                        - лв.
                    </div>
                </div>
            </div>

            <div class="modalGrid__item js-item">
                <div class="py-10 px-15 sm:px-5 sm:py-5">
                    <div class="text-15 lh-15 fw-500 text-dark-1">Canadian dollar</div>
                    <div class="text-14 lh-15 mt-5">
                        <span class="js-title">CAD</span>
                        - $
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="mapFilter" data-x="mapFilter" data-x-toggle="-is-active">
    <div class="mapFilter__overlay"></div>

    <div class="mapFilter__close">
        <button class="button -blue-1 size-40 bg-white shadow-2" data-x-click="mapFilter">
            <i class="icon-close text-15"></i>
        </button>
    </div>

    <div class="mapFilter__grid" data-x="mapFilter__grid" data-x-toggle="-filters-hidden">
        <div class="mapFilter-filter scroll-bar-1">
            <div class="px-20 py-20 md:px-15 md:py-15">
                <div class="d-flex items-center justify-between">
                    <div class="text-18 fw-500">Filters</div>

                    <button class="size-40 flex-center rounded-full bg-blue-1" data-x-click="mapFilter__grid">
                        <i class="icon-chevron-left text-12 text-white"></i>
                    </button>
                </div>

                <div class="mapFilter-filter__item">
                    <h5 class="text-18 fw-500 mb-10">Popular Filters</h5>
                    <div class="sidebar-checkbox">

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">
                                <div class="d-flex items-center">
                                    <div class="form-checkbox">
                                        <input type="checkbox">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>
                                    <div class="text-15 ml-10">Breakfast Included</div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">92</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">
                                <div class="d-flex items-center">
                                    <div class="form-checkbox">
                                        <input type="checkbox">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>
                                    <div class="text-15 ml-10">Romantic</div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">45</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">
                                <div class="d-flex items-center">
                                    <div class="form-checkbox">
                                        <input type="checkbox">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>
                                    <div class="text-15 ml-10">Airport Transfer</div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">21</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">
                                <div class="d-flex items-center">
                                    <div class="form-checkbox">
                                        <input type="checkbox">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>
                                    <div class="text-15 ml-10">WiFi Included </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">78</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">
                                <div class="d-flex items-center">
                                    <div class="form-checkbox">
                                        <input type="checkbox">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>
                                    <div class="text-15 ml-10">5 Star</div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">679</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mapFilter-filter__item">
                    <h5 class="text-18 fw-500 mb-10">Nightly Price</h5>
                    <div class="row x-gap-10 y-gap-30">
                        <div class="col-12">
                            <div class="js-price-rangeSlider">
                                <div class="text-14 fw-500"></div>

                                <div class="d-flex justify-between mb-20">
                                    <div class="text-15 text-dark-1">
                                        <span class="js-lower"></span>
                                        -
                                        <span class="js-upper"></span>
                                    </div>
                                </div>

                                <div class="px-5">
                                    <div class="js-slider"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mapFilter-filter__item">
                    <h5 class="text-18 fw-500 mb-10">Amenities</h5>
                    <div class="sidebar-checkbox">

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Breakfast Included</div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">92</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">WiFi Included </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">45</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Pool</div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">21</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Restaurant </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">78</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Air conditioning </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">679</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mapFilter-filter__item">
                    <h5 class="text-18 fw-500 mb-10">Star Rating</h5>
                    <div class="row x-gap-10 y-gap-10 pt-10">

                        <div class="col-auto">
                            <a href="#"
                                class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100">1</a>
                        </div>

                        <div class="col-auto">
                            <a href="#"
                                class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100">2</a>
                        </div>

                        <div class="col-auto">
                            <a href="#"
                                class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100">3</a>
                        </div>

                        <div class="col-auto">
                            <a href="#"
                                class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100">4</a>
                        </div>

                        <div class="col-auto">
                            <a href="#"
                                class="button -blue-1 bg-blue-1-05 text-blue-1 py-5 px-20 rounded-100">5</a>
                        </div>

                    </div>
                </div>

                <div class="mapFilter-filter__item">
                    <h5 class="text-18 fw-500 mb-10">Guest Rating</h5>
                    <div class="sidebar-checkbox">

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="form-radio d-flex items-center ">
                                    <div class="radio">
                                        <input type="radio" name="name">
                                        <div class="radio__mark">
                                            <div class="radio__icon"></div>
                                        </div>
                                    </div>
                                    <div class="ml-10">Any</div>
                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">92</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="form-radio d-flex items-center ">
                                    <div class="radio">
                                        <input type="radio" name="name">
                                        <div class="radio__mark">
                                            <div class="radio__icon"></div>
                                        </div>
                                    </div>
                                    <div class="ml-10">Wonderful 4.5+</div>
                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">45</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="form-radio d-flex items-center ">
                                    <div class="radio">
                                        <input type="radio" name="name">
                                        <div class="radio__mark">
                                            <div class="radio__icon"></div>
                                        </div>
                                    </div>
                                    <div class="ml-10">Very good 4+</div>
                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">21</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="form-radio d-flex items-center ">
                                    <div class="radio">
                                        <input type="radio" name="name">
                                        <div class="radio__mark">
                                            <div class="radio__icon"></div>
                                        </div>
                                    </div>
                                    <div class="ml-10">Good 3.5+ </div>
                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">78</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mapFilter-filter__item">
                    <h5 class="text-18 fw-500 mb-10">Style</h5>
                    <div class="sidebar-checkbox">

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Budget</div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">92</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Mid-range </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">45</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Luxury</div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">21</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Family-friendly </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">78</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Business </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">679</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mapFilter-filter__item">
                    <h5 class="text-18 fw-500 mb-10">Neighborhood</h5>
                    <div class="sidebar-checkbox">

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Central London</div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">92</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Guests&#39; favourite area </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">45</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Westminster Borough</div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">21</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Kensington and Chelsea </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">78</div>
                            </div>
                        </div>

                        <div class="row y-gap-10 items-center justify-between">
                            <div class="col-auto">

                                <div class="d-flex items-center">
                                    <div class="form-checkbox ">
                                        <input type="checkbox" name="name">
                                        <div class="form-checkbox__mark">
                                            <div class="form-checkbox__icon icon-check"></div>
                                        </div>
                                    </div>

                                    <div class="text-15 ml-10">Oxford Street </div>

                                </div>

                            </div>

                            <div class="col-auto">
                                <div class="text-15 text-light-1">679</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="mapFilter-results scroll-bar-1">
            <div class="px-20 py-20 md:px-15 md:py-15">
                <div class="row y-gap-10 justify-between">
                    <div class="col-auto">
                        <div class="text-14 text-light-1">
                            <span class="text-dark-1 text-15 fw-500">3,269 properties</span>
                            in Europe
                        </div>
                    </div>

                    <div class="col-auto">
                        <button class="button -blue-1 h-40 px-20 md:px-5 text-blue-1 bg-blue-1-05 rounded-100">
                            <i class="icon-up-down mr-10"></i>
                            Top picks for your search
                        </button>
                    </div>
                </div>


                <div class="mapFilter-results__item">
                    <div class="row x-gap-20 y-gap-20">
                        <div class="col-md-auto">
                            <div class="ratio ratio-1:1 size-120">
                                <img src="{{ asset('assets/front') }}/img/hotels/1.png" alt="image"
                                    class="img-ratio rounded-4">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="row x-gap-20 y-gap-10 justify-between">
                                <div class="col-lg">
                                    <h4 class="text-16 lh-17 fw-500">
                                        Great Northern Hotel, a Tribute Portfolio Hotel, London
                                        <span class="text-10 text-yellow-2">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </span>
                                    </h4>
                                </div>

                                <div class="col-auto">
                                    <button class="button -blue-1 size-30 flex-center bg-light-2 rounded-full">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row y-gap-10 justify-between items-end pt-24 lg:pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="size-38 rounded-4 flex-center bg-blue-1">
                                            <span class="text-14 fw-600 text-white">4.8</span>
                                        </div>

                                        <div class="ml-10">
                                            <div class="text-13 lh-14 fw-500">Exceptional</div>
                                            <div class="text-12 lh-14 text-light-1">3,014 reviews</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="text-14 text-light-1 mr-10">8 nights</div>
                                        <div class="fw-500">US$72</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mapFilter-results__item">
                    <div class="row x-gap-20 y-gap-20">
                        <div class="col-md-auto">
                            <div class="ratio ratio-1:1 size-120">
                                <img src="{{ asset('assets/front') }}/img/hotels/1.png" alt="image"
                                    class="img-ratio rounded-4">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="row x-gap-20 y-gap-10 justify-between">
                                <div class="col-lg">
                                    <h4 class="text-16 lh-17 fw-500">
                                        Great Northern Hotel, a Tribute Portfolio Hotel, London
                                        <span class="text-10 text-yellow-2">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </span>
                                    </h4>
                                </div>

                                <div class="col-auto">
                                    <button class="button -blue-1 size-30 flex-center bg-light-2 rounded-full">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row y-gap-10 justify-between items-end pt-24 lg:pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="size-38 rounded-4 flex-center bg-blue-1">
                                            <span class="text-14 fw-600 text-white">4.8</span>
                                        </div>

                                        <div class="ml-10">
                                            <div class="text-13 lh-14 fw-500">Exceptional</div>
                                            <div class="text-12 lh-14 text-light-1">3,014 reviews</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="text-14 text-light-1 mr-10">8 nights</div>
                                        <div class="fw-500">US$72</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mapFilter-results__item">
                    <div class="row x-gap-20 y-gap-20">
                        <div class="col-md-auto">
                            <div class="ratio ratio-1:1 size-120">
                                <img src="{{ asset('assets/front') }}/img/hotels/1.png" alt="image"
                                    class="img-ratio rounded-4">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="row x-gap-20 y-gap-10 justify-between">
                                <div class="col-lg">
                                    <h4 class="text-16 lh-17 fw-500">
                                        Great Northern Hotel, a Tribute Portfolio Hotel, London
                                        <span class="text-10 text-yellow-2">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </span>
                                    </h4>
                                </div>

                                <div class="col-auto">
                                    <button class="button -blue-1 size-30 flex-center bg-light-2 rounded-full">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row y-gap-10 justify-between items-end pt-24 lg:pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="size-38 rounded-4 flex-center bg-blue-1">
                                            <span class="text-14 fw-600 text-white">4.8</span>
                                        </div>

                                        <div class="ml-10">
                                            <div class="text-13 lh-14 fw-500">Exceptional</div>
                                            <div class="text-12 lh-14 text-light-1">3,014 reviews</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="text-14 text-light-1 mr-10">8 nights</div>
                                        <div class="fw-500">US$72</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mapFilter-results__item">
                    <div class="row x-gap-20 y-gap-20">
                        <div class="col-md-auto">
                            <div class="ratio ratio-1:1 size-120">
                                <img src="{{ asset('assets/front') }}/img/hotels/1.png" alt="image"
                                    class="img-ratio rounded-4">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="row x-gap-20 y-gap-10 justify-between">
                                <div class="col-lg">
                                    <h4 class="text-16 lh-17 fw-500">
                                        Great Northern Hotel, a Tribute Portfolio Hotel, London
                                        <span class="text-10 text-yellow-2">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </span>
                                    </h4>
                                </div>

                                <div class="col-auto">
                                    <button class="button -blue-1 size-30 flex-center bg-light-2 rounded-full">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row y-gap-10 justify-between items-end pt-24 lg:pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="size-38 rounded-4 flex-center bg-blue-1">
                                            <span class="text-14 fw-600 text-white">4.8</span>
                                        </div>

                                        <div class="ml-10">
                                            <div class="text-13 lh-14 fw-500">Exceptional</div>
                                            <div class="text-12 lh-14 text-light-1">3,014 reviews</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="text-14 text-light-1 mr-10">8 nights</div>
                                        <div class="fw-500">US$72</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mapFilter-results__item">
                    <div class="row x-gap-20 y-gap-20">
                        <div class="col-md-auto">
                            <div class="ratio ratio-1:1 size-120">
                                <img src="{{ asset('assets/front') }}/img/hotels/1.png" alt="image"
                                    class="img-ratio rounded-4">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="row x-gap-20 y-gap-10 justify-between">
                                <div class="col-lg">
                                    <h4 class="text-16 lh-17 fw-500">
                                        Great Northern Hotel, a Tribute Portfolio Hotel, London
                                        <span class="text-10 text-yellow-2">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </span>
                                    </h4>
                                </div>

                                <div class="col-auto">
                                    <button class="button -blue-1 size-30 flex-center bg-light-2 rounded-full">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row y-gap-10 justify-between items-end pt-24 lg:pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="size-38 rounded-4 flex-center bg-blue-1">
                                            <span class="text-14 fw-600 text-white">4.8</span>
                                        </div>

                                        <div class="ml-10">
                                            <div class="text-13 lh-14 fw-500">Exceptional</div>
                                            <div class="text-12 lh-14 text-light-1">3,014 reviews</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="text-14 text-light-1 mr-10">8 nights</div>
                                        <div class="fw-500">US$72</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mapFilter-results__item">
                    <div class="row x-gap-20 y-gap-20">
                        <div class="col-md-auto">
                            <div class="ratio ratio-1:1 size-120">
                                <img src="{{ asset('assets/front') }}/img/hotels/1.png" alt="image"
                                    class="img-ratio rounded-4">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="row x-gap-20 y-gap-10 justify-between">
                                <div class="col-lg">
                                    <h4 class="text-16 lh-17 fw-500">
                                        Great Northern Hotel, a Tribute Portfolio Hotel, London
                                        <span class="text-10 text-yellow-2">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </span>
                                    </h4>
                                </div>

                                <div class="col-auto">
                                    <button class="button -blue-1 size-30 flex-center bg-light-2 rounded-full">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row y-gap-10 justify-between items-end pt-24 lg:pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="size-38 rounded-4 flex-center bg-blue-1">
                                            <span class="text-14 fw-600 text-white">4.8</span>
                                        </div>

                                        <div class="ml-10">
                                            <div class="text-13 lh-14 fw-500">Exceptional</div>
                                            <div class="text-12 lh-14 text-light-1">3,014 reviews</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="text-14 text-light-1 mr-10">8 nights</div>
                                        <div class="fw-500">US$72</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mapFilter-results__item">
                    <div class="row x-gap-20 y-gap-20">
                        <div class="col-md-auto">
                            <div class="ratio ratio-1:1 size-120">
                                <img src="{{ asset('assets/front') }}/img/hotels/1.png" alt="image"
                                    class="img-ratio rounded-4">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="row x-gap-20 y-gap-10 justify-between">
                                <div class="col-lg">
                                    <h4 class="text-16 lh-17 fw-500">
                                        Great Northern Hotel, a Tribute Portfolio Hotel, London
                                        <span class="text-10 text-yellow-2">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </span>
                                    </h4>
                                </div>

                                <div class="col-auto">
                                    <button class="button -blue-1 size-30 flex-center bg-light-2 rounded-full">
                                        <i class="icon-heart text-12"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row y-gap-10 justify-between items-end pt-24 lg:pt-15">
                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="size-38 rounded-4 flex-center bg-blue-1">
                                            <span class="text-14 fw-600 text-white">4.8</span>
                                        </div>

                                        <div class="ml-10">
                                            <div class="text-13 lh-14 fw-500">Exceptional</div>
                                            <div class="text-12 lh-14 text-light-1">3,014 reviews</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="d-flex items-center">
                                        <div class="text-14 text-light-1 mr-10">8 nights</div>
                                        <div class="fw-500">US$72</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mapFilter-map">
            <div class="map js-map"></div>
        </div>
    </div>
</div>


<!-- JavaScript -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAz77U5XQuEME6TpftaMdX0bBelQxXRlM"></script>
<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>

<script src="{{ asset('assets/front/js/vendors.js') }}"></script>
<script src="{{ asset('assets/front/js/main.js') }}"></script>
