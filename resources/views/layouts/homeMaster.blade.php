<!DOCTYPE html>
<html>
<head>
    <title></title>
    <base href="{{ url('/') }}" token="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('public/assets/bootstrap/dist/css/bootstrap.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('public/assets/select2/dist/css/select2.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/homestyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/fontawesome/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/jquery/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/js/plugins/icheckbox/skins/flat/red.css') }}">
    <link rel="stylesheet" href="{{ asset('public/js/plugins/starrr/starrr.css') }}">
    <script src="{{ asset('public/js/plugins/jquery/jquery.min.js') }}" ></script>
    <script src="{{ asset('public/js/plugins/jquery/jquery-ui.min.js') }}" ></script>
    <script type="text/javascript">
        var baseUrl = $('base').attr('href');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('base').attr('token')
            }
        });
    </script>
</head>
<body style="background: url({{asset('public/images/39079980-food-wallpapers.jpg')}}) fixed no-repeat;">
        <div class="fixed-right mt-4 mr-3">
            <ul class="" id="menu-bar">
                <li class="mb-2">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg w-100 h-100 rounded-circle" title="{{ __('home') }}" data-toggle-tooltip="tooltip" data-placement="left">
                        <i class="fa fa-home"></i>
                    </a>                   
                </li>
                @if(Auth::user())
                <li class="mb-2">
                    <a href="{{ url('logout') }}" class="btn btn-danger btn-lg w-100 h-100 rounded-circle" title="{{ __('logout') }}" data-toggle-tooltip="tooltip" data-placement="left">
                        <i class="fa fa-sign-out"></i>
                    </a>                   
                </li>
                <li class="mb-2">
                    <button data-target="#myModal" class="btn btn-warning btn-lg w-100 h-100 rounded-circle" title="{{ __('suggest') }}" data-toggle-tooltip="tooltip" data-placement="left" data-toggle="modal">
                        <i class="fa fa-beer"></i>
                    </a>                   
                </li>
                @else
                <li class="mb-2">
                    <a href="{{ url('login') }}" class="btn btn-info btn-lg w-100 h-100 rounded-circle" title="{{ __('login') }}" data-toggle-tooltip="tooltip" data-placement="left">
                        <i class="fa fa-sign-in"></i>
                    </a>                   
                </li>
                @endif                
                <li class="mb-2">
                    <button type="button" data-target="#chooseFoodModal" data-toggle="modal" class="btn btn-success btn-lg w-100 h-100 rounded-circle" title="{{ __('chooseSomething4u') }}" data-toggle-tooltip="tooltip" data-placement="left">
                        <i class="fa fa-apple"></i>
                    </a>                   
                </li>
            </ul>
        </div>
        
        @yield('homeMaster')
        
        @if(Auth::user())
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('suggestUsTitle') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-5 ava-frame">
                                <img id="avatarImage" class="img-fluid img-thumbnail ava-img" src="{{ asset('public/images/1462234361-thit-cho-la-mo_TQEL.jpg') }}" alt="">
                                <div class="avatar-upload">
                                    <h4><i class="fa fa-repeat"></i></h4>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                {!! Form::open([
                                    'url' => route('suggest'),
                                    'method' => 'POST',
                                    'id' => 'foodForm',
                                    'enctype' => 'multipart/form-data'
                                ]) !!}
                                    <div class="form-group" id="foodName">
                                        <label>{{ __('fName') }}:</label>
                                        <input type="text" name="food" class="form-control" placeholder="{{ __('fNameHolder') }}">
                                    </div>
                                    <div class="form-group" id="foodType">
                                        <label>{{ __('foodTypes') }}:</label>
                                        <br>
                                        {!! Form::select('food_type[]', $selectType, null, ['class' => 'form-control select2', 'id' => 'select2FoodType', 'multiple' => true]) !!}
                                    </div>
                                    <div class="form-group" id="description">
                                        <label>{{ __('description') }}:</label>
                                        <textarea class="form-control" name="description" cols="30" rows="2" placeholder="{{ __('fDescriptionHolder') }}"></textarea>
                                    </div>
                                    <div class="form-group" id="groupAddress">
                                        <div class="group-address mb-2">
                                            <label>{{ __('address') }} & {{ __('price') }}:</label>
                                            <input type="text" name="address[]" class="form-control" placeholder="{{ __('address') }}">
                                            <div class="row pt-1 pl-3 pl-3 mb-3">
                                                <input class="col-sm-4 form-control" name="price[]" type="text" placeholder="{{ __('price') }}">
                                                <select name="currency[]" class="form-control col-sm-3">
                                                    <option value="VND">VND</option>
                                                    <option value="USD">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-success" data-toggle-tooltip="tooltip" name="addLineAddress" data-placement="bottom" title="{{ __('btnAddAP') }}">
                                            <i class="fa fa-plus"></i>
                                        </button>                        
                                    </div>
                                    <input type="file" class="hide" name="hideImg">
                                    <br>
                                    <button type="submit" class="btn btn-info" name="submit" value="insert">{{ __('suggest') }}</button>
                                    {!! Form::close() !!}
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div id="chooseFoodModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row" id="groupButtonChooseFood">
                            <div class="col-md-4">
                                <img class="mx-auto d-block img-fluid" src="https://cdn0.iconfinder.com/data/icons/kameleon-free-pack-rounded/110/Food-Dome-512.png" alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="col-md-12" id="chooseGroup">
                                    <h4 class="text-info">{{ __('letSee') }}</h4>
                                    <p class="mt-lg-4"><button name="allRandom" class="btn btn-outline-warning btn-max allRandom">{{ __('allrandom') }}</button></p>
                                    <p><button name="openType" class="btn btn-outline-success btn-max">{{ __('choose1') }}</button></p>
                                </div>
                                <div class="col-md-12 hide" id="chooseFoodType">
                                    <h4 class="text-info">{{ __('youShouldChoose') }}</h4>
                                    <div class="row mt-4 p-3" id="groupFoodType">
                                        @foreach($listType as $item)
                                        <label class="control-label col-md-4 mb-4 p-0">
                                            <input class="icheckbox" type="checkbox" value="{{ $item['id'] }}">
                                            {{ $item['types'] }}
                                        </label>
                                        @endforeach
                                    </div>
                                    <div class="col-md-12 p-0">
                                        <button name="findFoodRandomWithType" class="btn btn-info btn-outline-primary btn-max mb-3">{{ __('choose2') }}</button>
                                        <button name="findFood" class="btn btn-info btn-outline-danger btn-max mb-3">{{ __('choose2') }}</button>
                                        <div id="errorNotChoose"></div>
                                        <a href="javascript:void(0)" id="goBack"><i class="fa fa-arrow-left"></i> {{ __('goback') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="resultReturned">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="{{ asset('public/assets/bootstrap/assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('public/assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/js/plugins/icheckbox/icheck.min.js') }}"></script>
    <script src="{{ asset('public/js/plugins/starrr/starrr.js') }}"></script>
    <script src="{{ asset('public/js/setup.js') }}" type="text/javascript"></script>
    @if(session('success'))
    <script type="text/javascript">
        $(document).ready(function(){
            var html = `
                <div class="col-md-4 mt-5 text-center notification noti-success">
                    <p class="mt-3">
                        <i class="fa fa-check"></i>
                        <b id="notiMessage">{{ __('suggestSuccess') }}</b>
                    </p>
                </div>
            `;
            $('body').append(html);
            setTimeout(function(){
                $('.notification').remove();
            }, 3000);
        }); 
    </script>
    @endif
</body>
</html>
