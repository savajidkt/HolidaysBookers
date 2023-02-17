@extends('layouts.app')
@section('page_title', 'Thank You')
@section('content')
@php
$download =  url('/user/survey-export/'.Auth::user()->id); Auth::user()->id;
@endphp
<section class="section small-c">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 general-card">
                <div class="card thank-you">
                    <img style="display:none;" src="{{asset('front/assets/img/card.jpg')}}" class="card-img-top" alt="...">
                    <div class="card-img-overlay">
                        <p class="card-text">Thank you for completing the assessment. One of our team members will reach out to you shortly to schedule your debrief. Please feel free to explore our website for more information on Relational Intelligence, coaching, and executive development.</p>

                         <p class="card-text"><a href="https://bandelliandassociates.com/" target="_blank" class="btn btn-primary">Visit Our Website</a></p>     
                       
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
