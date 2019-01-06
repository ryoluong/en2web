<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="showCountries">
            <div class="no_border_card">
                <div class="title">
                    <div class="table_view">
                        <a class="icon" href="/countries">
                            <img src="/img/top_world.png" alt="note">
                        </a>
                        <div class="text">
                            <a href="/countries">
                            {{ 'Countries' }}
                            </a>
                        </div>
                    </div>
                </div>
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
    </body>
</html>
