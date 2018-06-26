@extends('layouts.homeMaster')
@section('homeMaster')

@if($allowHeadBoard)
<div class="container p-0 mt-lg-4 main-bg">
    <div class="row m-0">
        <div class="col-lg-6 p-0">
            @if ($headItem['images'])
            <img class="card-img-top img-thumbnail mx-auto d-block fixed-size-head img-fluid" src="{{ asset('public/images') }}/{{ $headItem['images'][0]['url'] }}" alt="{{ $headItem['food'] }}">
            @else
            <img class="card-img-top img-thumbnail mx-auto d-block fixed-size-head img-fluid" src="{{ asset('public/images/1462234361-thit-cho-la-mo_TQEL.jpg') }}">
            @endif
        </div>
        <div class="col-lg-5 m-lg-3">
            <p><small class="text-muted">
            @php 
            $c = 0;
            @endphp
            @foreach($headItem['types'] as $k => $v)
                {{ $v['types'] }}
                @if($c < count($headItem['types'])-1)
                    /
                @endif
                @php 
                    $c+=1; 
                @endphp
            @endforeach
            </small></p>
            <p><h1 class="food-title">{{ $headItem['food'] }}</h1></p>
            <p>{{ $headItem['description'] }}</p>
            <p id="star1" class="starrr">
            @foreach($headItem['rateStar'] as $s)
                <i class="fa fa-{{ $s }} mr-1"></i>
            @endforeach
                <i class="ml-3 rating-line">{{ $headItem['total_score']/$headItem['rate_times'] }} / {{ $headItem['rate_times'] }} Rate</i></p>
            <p class="price-line"><i class="fa fa-money mr-3 "></i> 35.000 VND</p>      
                <blockquote class="blockquote m-1">
                    <a class="text-info" href="#"><p class="mb-0 text-info"><i class="fa fa-map-marker"></i> Address:</p></a>
                    @if($headItem['addresses'])
                        @foreach($headItem['addresses'] as $v)
                            <footer class="blockquote-footer">{{ $v['address'] }}</footer>
                        @endforeach
                    @else
                        <footer class="blockquote-footer">Not have any address</footer>
                    @endif
                </blockquote>
            </a>
        </div>
    </div>
</div>
@endif

<div class="container p-0 mt-lg-4 main-bg">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Some other stuffs</h3>
        </div>
        <div class="card-body">
            <div class="row">
            @if ($listItem)
                @foreach ($listItem as $item)
                <div class="col-lg-4 mt-3 list-food">
                    <div class="card">
                        @if ($item['images'])
                        <img class="card-img-top img-thumbnail mx-auto d-block fixed-size img-fluid" src="{{ asset('public/images') }}/{{ $item['images'][0]['url'] }}" alt="{{ $item['food'] }}">
                        @else
                        <img class="card-img-top img-thumbnail mx-auto d-block fixed-size img-fluid" src="{{ asset('public/images/1462234361-thit-cho-la-mo_TQEL.jpg') }}">
                        @endif
                        <div class="card-body">
                            <p class="mb-1">
                                @if($item['types'])
                                <small class="text-muted">
                                @php 
                                $c = 0;
                                @endphp
                                @foreach ($item['types'] as $k => $v)
                                    {{ $v['types'] }}
                                    @if ($c < count($item['types'])-1)
                                        /
                                    @endif
                                    @php 
                                        $c+=1; 
                                    @endphp                                    
                                @endforeach
                                </small>
                                @else
                                <small>&nbsp;</small>
                                @endif
                            </p>
                            <h4 class="mb-1 card-title food-title">{{ $item['food'] }}</h4>
                            <p class="mb-2 card-text">{{ $item['description'] ? $item['description'] : '&nbsp;' }}</p>
                            <p class="mb-2 price-line"><i class="fa fa-money mr-3 "></i> 35.000 VND</p>
                            <p class="mb-0">
                                @if(Auth::user())
                                <span class="vote-frame" food="{{ $item['id'] }}">
                                    <span class="vote-frame-main">
                                @foreach ($item['rateStar'] as $s)
                                    <i class="fa fa-{{ $s }} mr-1"></i>
                                @endforeach
                                    </span>
                                    <span class="vote-frame-o-star hide">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star-o mr-1 vote-star" level="{{ $i+1 }}"></i>
                                    @endfor
                                    </span>
                                </span>
                                @else
                                <a class="vote-frame" href="{{ url('/login') }}">
                                    <span class="vote-frame-main">
                                    @foreach ($item['rateStar'] as $s)
                                        <i class="fa fa-{{ $s }} mr-1"></i>
                                    @endforeach
                                    </span>
                                    <span class="vote-frame-o-star hide">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star-o mr-1" level="{{ $i+1 }}"></i>
                                    @endfor
                                    </span>
                                </a>
                                @endif
                                <i class="ml-3 rating-line">{{ ($item['rate_times'] == 0) ? '0' : $item['total_score']/$item['rate_times'] }} / {{ $item['rate_times'] }} Rate</i></p>
                            </p>
                            <p class="text-center mb-0 mt-3"><button class="btn btn-outline-info" value="{{ $item['id'] }}"><i class="fa fa-map-marker"></i> Give me Address</button></p>
                      </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-md-12 text-center">
                    <h3 class="text-info">{{ __('foundZero') }}</h3>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
