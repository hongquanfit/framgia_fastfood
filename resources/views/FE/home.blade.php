@extends('layouts.homeMaster')
@section('homeMaster')
<div class="container p-0 mt-lg-4 main-bg">
<div class="row m-0">
    <div class="col-lg-6 p-0">
        <img src="{{ asset('public/images/39079980-food-wallpapers.jpg') }}" class="rounded img-fluid img-thumbnail">
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
            @php $c+=1; @endphp
        @endforeach
        </small></p>
        <p><h1 class="food-title">{{ $headItem['food'] }}</h1></p>
        <p>{{ $headItem['description'] }}</p>
        <p>
        @foreach($headItem['rateStar'] as $s)
            <i class="fa fa-{{ $s }} mr-1"></i>
        @endforeach
            <i class="ml-3 rating-line">{{ $headItem['total_score']/5 }} / {{ $headItem['rate_times'] }} Rate</i></p>
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

<div class="container p-0 mt-lg-4 main-bg">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Some other stuffs</h2>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($listItem as $item)
                <div class="col-lg-4 mt-3 list-food">
                    <div class="card">
                        <img class="card-img-top img-thumbnail" src="{{ asset('public/images/1462234361-thit-cho-la-mo_TQEL.jpg') }}" alt="Card image">
                        <div class="card-body">
                            <p class="mb-1">
                                <small class="text-muted">
                                @php 
                                $c = 0;
                                @endphp
                                @foreach ($item['types'] as $k => $v)
                                    {{ $v['types'] }}
                                    @if ($c < count($item['types'])-1)
                                        /
                                    @endif
                                    @php $c+=1; @endphp                                    
                                @endforeach
                                </small>
                            </p>
                            <h4 class="mb-1 card-title food-title">{{ $item['food'] }}</h4>
                            <p class="mb-2 card-text">{{ $item['description'] }}</p>
                            <p class="mb-2 price-line"><i class="fa fa-money mr-3 "></i> 35.000 VND</p>
                            <p class="mb-0">
                                @foreach ($item['rateStar'] as $s)
                                    <i class="fa fa-{{ $s }} mr-1"></i>
                                @endforeach
                                <i class="ml-3 rating-line">{{ $item['total_score']/5 }} / {{ $item['rate_times'] }} Rate</i></p>
                            </p>
                            <p class="text-center mb-0 mt-3"><button class="btn btn-outline-info" value="{{ $item['id'] }}"><i class="fa fa-map-marker"></i> Give me Address</button></p>
                      </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection