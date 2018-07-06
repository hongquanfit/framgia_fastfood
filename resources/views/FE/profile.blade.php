@extends('layouts.homeMaster')
@section('homeMaster')
<div class="container p-0 mt-lg-4 main-bg">
    <div class="row m-0 pt-4 pb-4">
        <div class="col-lg-2">
            
        </div>
        <div class="col-lg-3">
            <img src="{{ asset('public/images') }}/user.png" width="100%">
        </div>
        <div class="col-lg-7">
            {!! Form::open([
                'url' => route('profile.edit'),
                'method' => 'post',
            ]) !!}
                <div class="form-group">
                    <label>{{ __('Name') }}:</label>
                    <input type="text" class="form-control btn-75" name="name" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group">
                    <label>{{ __('Email') }}:</label>
                    <input type="text" class="form-control btn-75" disabled="" value="{{ Auth::user()->email }}">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-2">
                            <label>{{ __('Sex') }}</label>
                            <br>
                            <input class="icheckbox" name="sex" type="radio" value="Male">
                            {{ __('Male') }}
                            <br>
                            <input class="icheckbox" name="sex" type="radio" value="Female">
                            {{ __('Female') }}
                        </div>
                        <div class="col-lg-2">
                            <label>{{ __('Age') }}:</label>
                            <input type="number" class="form-control" name="age">
                        </div>
                        <div class="col-lg-2">
                            <label>{{ __('Height') }}:</label>
                            <input type="number" class="form-control" name="heightBMI">
                        </div>
                        <div class="col-lg-2">
                            <label>{{ __('Weight') }}:</label>
                            <input type="number" class="form-control" name="weightBMI">
                        </div>
                    </div>
                </div>
                {!! Form::button('Add', [
                    'name' => 'submit',
                    'value' => 'ok',
                    'class' => 'btn btn-outline-success btn-75',
                ]) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="container p-0 mt-lg-4 main-bg">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Your favorites') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
            @if ($listItem)
                @foreach ($listItem as $item)
                <div class="col-lg-3 mt-3 list-food">
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
                            <p class="price-line font-16"><i class="fa fa-money mr-3 "></i> {{ $item['price'] }}</p>
                            @if(Auth::user())
                            <p class="favorite-line"><span class="favorite-icon" id="{{ $item['id'] }}" data-like="{{ $item['favorites'] ? 'like' : 'unlike' }}"><i class="fa fa-heart{{ $item['favorites'] ? ' text-danger' : '-o' }}"></i></span> {{ $item['favorites'] ? __('You liked this') : __('Add to favorite') }}</p>
                            @else
                            <p class="favorite-line"><a href="{{ url('/login') }}"><i class="fa fa-heart-o"></i> {{ __('Add to favorite') }}</a></p>
                            @endif
                            <p class="calorie-line text-danger">
                                <i class="fa fa-sun-o"></i> {{ $item['total_calorie'] }} {{ __('Kcal') }}
                            </p>
                            <p class="mb-0 star-line">
                                @if(Auth::user())
                                <span class="vote-frame" data-vote-item="{{ $item['id'] }}">
                                    <span class="vote-frame-main">
                                @foreach ($item['rateStar'] as $s)
                                    <i class="fa fa-{{ $s }} mr-1"></i>
                                @endforeach
                                    </span>
                                    <span class="vote-frame-o-star hide">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star-o mr-1 vote-star" data-vote-type="food" level="{{ $i+1 }}"></i>
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
                                <i class="ml-3 rating-line font-11">{{ ($item['rate_times'] == 0) ? '0' : round($item['total_score']/$item['rate_times'], 2) }} / {{ $item['rate_times'] }} {{ __('rate') }}</i></p>
                            </p>
                            <small class="text-success" id="infoSaveComment_{{ $item['id'] }}"></small>
                            <p class="text-center mb-0 mt-3"><a class="btn btn-outline-info" target="_blank()" href="{{ url('/details/') }}/{{ str_slug($item['food']) }}_{{ $item['id'] }}"><i class="fa fa-map-marker"></i> {{ __('details') }}</a></p>
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

<div class="container p-0 mt-lg-4 main-bg">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('This may be good for your health') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
            @if ($listByCalorie)
                @foreach ($listByCalorie as $item)
                <div class="col-lg-3 mt-3 list-food">
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
                            <p class="price-line font-16"><i class="fa fa-money mr-3 "></i> {{ $item['price'] }}</p>
                            @if(Auth::user())
                            <p class="favorite-line"><span class="favorite-icon" id="{{ $item['id'] }}" data-like="{{ $item['favorites'] ? 'like' : 'unlike' }}"><i class="fa fa-heart{{ $item['favorites'] ? ' text-danger' : '-o' }}"></i></span> {{ $item['favorites'] ? __('You liked this') : __('Add to favorite') }}</p>
                            @else
                            <p class="favorite-line"><a href="{{ url('/login') }}"><i class="fa fa-heart-o"></i> {{ __('Add to favorite') }}</a></p>
                            @endif
                            <p class="calorie-line text-danger">
                                <i class="fa fa-sun-o"></i> {{ $item['total_calorie'] }} {{ __('Kcal') }}
                            </p>
                            <p class="mb-0 star-line">
                                @if(Auth::user())
                                <span class="vote-frame" data-vote-item="{{ $item['id'] }}">
                                    <span class="vote-frame-main">
                                @foreach ($item['rateStar'] as $s)
                                    <i class="fa fa-{{ $s }} mr-1"></i>
                                @endforeach
                                    </span>
                                    <span class="vote-frame-o-star hide">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star-o mr-1 vote-star" data-vote-type="food" level="{{ $i+1 }}"></i>
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
                                <i class="ml-3 rating-line font-11">{{ ($item['rate_times'] == 0) ? '0' : round($item['total_score']/$item['rate_times'], 2) }} / {{ $item['rate_times'] }} {{ __('rate') }}</i></p>
                            </p>
                            <small class="text-success" id="infoSaveComment_{{ $item['id'] }}"></small>
                            <p class="text-center mb-0 mt-3"><a class="btn btn-outline-info" target="_blank()" href="{{ url('/details/') }}/{{ str_slug($item['food']) }}_{{ $item['id'] }}"><i class="fa fa-map-marker"></i> {{ __('details') }}</a></p>
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

<div class="container p-0 mt-lg-4 main-bg">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Your most interaction item') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
            @if ($mostInteractionItem)
                @foreach ($mostInteractionItem as $item)
                <div class="col-lg-3 mt-3 list-food">
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
                            <p class="price-line font-16"><i class="fa fa-money mr-3 "></i> {{ $item['price'] }}</p>
                            @if(Auth::user())
                            <p class="favorite-line"><span class="favorite-icon" id="{{ $item['id'] }}" data-like="{{ $item['favorites'] ? 'like' : 'unlike' }}"><i class="fa fa-heart{{ $item['favorites'] ? ' text-danger' : '-o' }}"></i></span> {{ $item['favorites'] ? __('You liked this') : __('Add to favorite') }}</p>
                            @else
                            <p class="favorite-line"><a href="{{ url('/login') }}"><i class="fa fa-heart-o"></i> {{ __('Add to favorite') }}</a></p>
                            @endif
                            <p class="calorie-line text-danger">
                                <i class="fa fa-sun-o"></i> {{ $item['total_calorie'] }} {{ __('Kcal') }}
                            </p>
                            <p class="mb-0 star-line">
                                @if(Auth::user())
                                <span class="vote-frame" data-vote-item="{{ $item['id'] }}">
                                    <span class="vote-frame-main">
                                @foreach ($item['rateStar'] as $s)
                                    <i class="fa fa-{{ $s }} mr-1"></i>
                                @endforeach
                                    </span>
                                    <span class="vote-frame-o-star hide">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star-o mr-1 vote-star" data-vote-type="food" level="{{ $i+1 }}"></i>
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
                                <i class="ml-3 rating-line font-11">{{ ($item['rate_times'] == 0) ? '0' : round($item['total_score']/$item['rate_times'], 2) }} / {{ $item['rate_times'] }} {{ __('rate') }}</i></p>
                            </p>
                            <small class="text-success" id="infoSaveComment_{{ $item['id'] }}"></small>
                            <p class="text-center mb-0 mt-3"><a class="btn btn-outline-info" target="_blank()" href="{{ url('/details/') }}/{{ str_slug($item['food']) }}_{{ $item['id'] }}"><i class="fa fa-map-marker"></i> {{ __('details') }}</a></p>
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