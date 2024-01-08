<footer class="footer -type-2 bg-light-2">
    <div class="container">
        <div class="pt-60 pb-60">
            <div class="row y-gap-40 justify-between xl:justify-start">
                <div class="col-xl-4 col-lg-6">
                    <img src="{{ asset('assets/front') }}/img/general/logo-dark.png" alt="image">

                    <div class="row y-gap-30 justify-between pt-30">
                        <div class="col-sm-6">
                            <div class="text-14">Phone</div>
                            <a href="tel:+9910560003" class="text-18 fw-500 text-dark-1 mt-5">+ 9910560003</a>
                        </div>

                        <div class="col-sm-5">
                            <div class="text-14">Need live support?</div>
                            <a href="mailto: info@holidaysbookers.com" class="text-18 fw-500 text-dark-1 mt-5">info@holidaysbookers.com</a>
                        </div>
                    </div>
                    <div class="mt-60">
                        <h5 class="text-16 fw-500 mb-10">Follow us on social media</h5>
                        <div class="d-flex x-gap-20 items-center">
                            <a target="_blank" href="https://www.facebook.com/holidaysbookers"><i
                                    class="icon-facebook text-14"></i></a>
                            <a target="_blank" href="https://twitter.com/Viveshkat"><i
                                    class="icon-twitter text-14"></i></a>
                            <a target="_blank" href="https://www.instagram.com/holidaysbookersdmc/"><i
                                    class="icon-instagram text-14"></i></a>
                            <a target="_blank" href="https://www.youtube.com/channel/UCi2tUiEPlCTIJvz_bJdbZLA"><i
                                    class="icon-play text-14"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row y-gap-30">
                        <div class="col-lg-4 col-sm-6">
                            <h5 class="text-16 fw-500 mb-30">Company</h5>
                            <div class="d-flex y-gap-10 flex-column">
                                <a href="#">About Us</a>
                                <a href="#">Careers</a>
                                <a href="#">Blog</a>
                                <a href="#">Press</a>
                                <a href="#">Gift Cards</a>
                                <a href="#">Magazine</a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6">
                            <h5 class="text-16 fw-500 mb-30">Support</h5>
                            <div class="d-flex y-gap-10 flex-column">
                                <a href="#">Contact</a>
                                <a href="#">Legal Notice</a>
                                <a href="#">Privacy Policy</a>
                                <a href="#">Terms and Conditions</a>
                                <a href="#">Sitemap</a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6">
                            <h5 class="text-16 fw-500 mb-30">Other Services</h5>
                            <div class="d-flex y-gap-10 flex-column">
                                <a href="#">Car hire</a>
                                <a href="#">Activity Finder</a>
                                <a href="#">Tour List</a>
                                <a href="#">Flight finder</a>
                                <a href="#">Cruise Ticket</a>
                                <a href="#">Holiday Rental</a>
                                <a href="#">Travel Agents</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-20 border-top-light">
            <div class="row justify-between items-center y-gap-10">
                <div class="col-auto">
                    <div class="row x-gap-30 y-gap-10">
                        <div class="col-auto">
                            <div class="d-flex items-center">
                                © 2023 Holidays Bookers All rights reserved.
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex x-gap-15">
                                <a href="#">Privacy</a>
                                <a href="#">Terms</a>
                                <a href="#">Site Map</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript">
    var moduleConfigCommon = {
        allCurrencies: "{!! route('get-currencies') !!}",
        setCurrencies: "{!! route('set-currencies') !!}"
    };
</script>