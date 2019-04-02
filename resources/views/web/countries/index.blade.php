@extends('layouts.app')
@section('title', ' - Countries')
@section('content')
        <div id="showCountries">
            <div class="content_head with_border">
                <a class="icon" href="/countries">
                    <img src="/img/top_world.png" alt="note">
                </a>
                <div class="text">
                    <a href="/countries">Countries</a>
                </div>
            </div>
            <div class="no_border_card">
                <div class="flex_container">
                    @foreach($countries as $country)
                    <div class="flex_view">
                        <a class="country_flag" href="/countries/{{ $country->country_id }}"><img src="/img/flags/{{ $country->english_name }}.png" alt=""></a>
                        <a class="country_name" href="/countries/{{ $country->country_id }}">{{ $country->name }}</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
@endsection
