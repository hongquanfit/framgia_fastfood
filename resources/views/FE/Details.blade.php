@extends('layouts.homeMaster')
@section('homeMaster')
<div class="container p-0 mt-lg-4 main-bg">
    <div class="row m-0">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6">
                    @if ($headItem['images'])
                    <img class="card-img-top img-thumbnail mx-auto d-block fixed-size-head img-fluid" src="{{ asset('public/images') }}/{{ $headItem['images'][0]['url'] }}" alt="{{ $headItem['food'] }}">
                    @else
                    <img class="card-img-top img-thumbnail mx-auto d-block fixed-size-head img-fluid" src="{{ asset('public/images/1462234361-thit-cho-la-mo_TQEL.jpg') }}">
                    @endif
                </div>
                <div class="col-lg-5 m-lg-3 pt-4">
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
                        <i class="ml-3 rating-line">{{ ($headItem['rate_times'] == 0) ? '0' : $headItem['total_score']/$headItem['rate_times'] }} / {{ $headItem['rate_times'] }} {{ __('rate') }}</i></p>
                    <p class="comment-line"><a href="{{ url('/details/') }}/{{ str_slug($headItem['food']) }}_{{ $headItem['id'] }}#"><i class="fa fa-comments-o mr-3"></i> {{ $headItem['countComment'] }} {{ __('comments') }}</a></p>
                    <p class="price-line font-16"><i class="fa fa-money mr-3 "></i> {{ $headItem['price'] }} VND</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container p-0 mt-lg-4 main-bg">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('addresses') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($headAddress as $address)
                <div class="col-lg-3 mb-4">
                    <div class="card">
                        @if ($address['avatar'])
                        <img class="card-img-top img-thumbnail mx-auto d-block fixed-size img-fluid" src="{{ asset('public/images') }}/{{ $address['avatar'] }}" alt="{{ $address['address'] }}">
                        @else
                        <img class="card-img-top img-thumbnail mx-auto d-block fixed-size img-fluid" src="{{ asset('public/images/store.jpg') }}">
                        @endif
                        <div class="card-body">
                            <h4 class="mb-1 card-title food-title font-14">{{ $address['address'] }}</h4>
                            <p class="mb-2 price-line font-13"><i class="fa fa-money mr-2"></i> {{ number_format($address['price'], 0) }} VND</p>
                            <p class="mb-0 star-line">
                                @if(Auth::user())
                                <span class="vote-frame" food="{{ $address['id'] }}">
                                    <span class="vote-frame-main">
                                @foreach ($address['rateStar'] as $s)
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
                                    @foreach ($address['rateStar'] as $s)
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
                                <i class="ml-3 rating-line">{{ ($address['rate_times'] == 0) ? '0' : $address['total_score']/$address['rate_times'] }} / {{ $address['rate_times'] }} {{ _('rate') }}</i></p>
                            </p>
                            <p class="suggest-line"><i class="fa fa-plus-square-o mr-2"></i> {{ __('addedBy') }} <b class="text-info">{{ $address['whoAdded'] ? $address['whoAdded']['name'] : '???' }}</b></p>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-lg-3 mb-4">
                    <div class="add-icon-box" data-toggle-tooltip="tooltip" title="{{ __('addAdr') }}" data-toggle="modal" data-target="#modalAddAdr">
                            <h1>+</h1>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="col-lg-12">
                    <p><h3>{{ __('rate') }} & {{ __('comments') }}</h3></p>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-3">
                        @for($i = 0; $i < 5; $i++)
                            <p class="text-right">
                                @for($j = $i; $j < 5; $j++)
                                <i class="fa fa-star mr-2"></i>
                                @endfor
                                <kbd class="font-14">4</kbd>
                            </p>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalAddAdr" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                @if(Auth::user())
                {!! Form::open([
                    'method' => 'POST',
                    'url' => route('user.addAdr'),
                    'enctype' => 'multipart/form-data',
                ]) !!}
                    <div class="form-group" id="groupAddress">
                        <div class="group-address mb-2">
                            <div class="row">
                                <div class="col-lg-8">
                                    <label>{{ __('address') }} & {{ __('price') }}:</label>
                                    <input type="text" name="address" class="form-control add-address" placeholder="{{ __('address') }}">
                                    <!-- <p></p> -->
                                    <div class="address-found-box">
                                    </div>
                                    <div class="row pt-1 pl-3 pl-3 mb-3">
                                        <input class="col-sm-4 form-control" name="price" type="text" placeholder="{{ __('price') }}">
                                        {!! Form::select('currency', $currency, null, [
                                            'class' => 'form-control col-sm-3'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <img src="{{ asset('public/images') }}/store.jpg" class="img-thumbnail avatar-img">
                                    <input type="file" name="adrAvatar" class="hide adrAvatar">
                                </div>
                            </div>
                        </div>                       
                    </div>
                    <p class="text-center">
                        {!! Form::button('Add', [
                            'name' => 'food',
                            'value' => $headItem['id'],
                            'class' => 'btn btn-outline-info',
                        ]) !!}
                    </p>
                {!! Form::close() !!}
                @else
                    <p class="text-center"><a href="{{ url('/login') }}" class="btn btn-outline-info">{{ __('mustLogin') }}</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
