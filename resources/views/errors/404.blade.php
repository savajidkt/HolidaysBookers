@extends('layouts.app')
@section('page_title', '404 Page not found')
@section('content')
    <section class="layout-pt-lg layout-pb-lg">
        <div class="container">
            <div class="row y-gap-30 justify-between items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('assets/front') }}/img/general/404.svg" alt="404">
                </div>
                <div class="col-lg-5">
                    <div class="no-page">
                        <div class="no-page__title">40<span class="text-blue-1">4</span></div>
                        <h2 class="text-30 fw-600">Oops! It looks like you're lost.</h2>
                        <div class="pr-30 mt-5">The page you're looking for isn't available. Try to search again or use the
                            go to.</div>
                        <div class="d-inline-block mt-40 md:mt-20">
                            <a href="{{ route('home') }}" class="button -md -dark-1 bg-blue-1 text-white">Go back to homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection