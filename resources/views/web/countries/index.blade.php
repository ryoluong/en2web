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
                            <div class="icon">
                                <img src="img/top_world.png" alt="">
                            </div>
                            <div class="text"><p>Countries</p></div>
                        </div>
                    </div>
                    <div class="flex_container">
                        @foreach($ids as $id)
                        <div class="flex_view">
                            <a class="country_flag" href="/countries/{{ $countries->where('id', $id->country_id)->first()->id }}"><img src="/img/flags/{{ $countries->where('id', $id->country_id)->first()->id }}.png" alt=""></a>
                            <a class="country_name" href="/countries/{{ $countries->where('id', $id->country_id)->first()->id }}">{{ $countries->where('id', $id->country_id)->first()->name }}</a>
                        </div>
                        @endforeach
                    </div>
                </div>
        </div>
    </body>
</html>
