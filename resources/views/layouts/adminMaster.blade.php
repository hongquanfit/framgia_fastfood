<!DOCTYPE html>
<html>
<head>
    <title>First Project</title>
    <base href="{{url('/')}}" token="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <base > -->
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/theme-default.css')}}">
    <link rel="stylesheet" href="{{ asset('public/js/plugins/icheckbox/skins/flat/red.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/select2/dist/css/select2.min.css') }}" >
    <script type="text/javascript" src="{{asset('public/js/plugins/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('base').attr('token')
            }
        });
    </script>
</head>
<body style="height: ">
<div class="page-container page-navigation-toggled page-container-wide">
    <div class="page-sidebar">
        <ul class="x-navigation x-navigation-minimized">
            <li class="xn-logo">
                <a href="#">BLA</a>
                <a href="#" class="x-navigation-control"></a>
            </li>
            <li class="xn-profile">
                <div class="profile">
                    <div class="profile-data">
                        <div class="profile-data-name">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                </div>
            </li>
            <li class="xn-profile">
                <a href="#" class="profile-mini">
                    <img src="{{ asset('public/images/user.png') }}" alt="John Doe">
                </a>
            </li>
            <li data-toggle-tooltip="tooltip" title="Type List" data-placement="right">
                <a href="{{ url('admin/type') }}">
                    <i class="fa fa-list"></i>
                    <span class="xn-text">{{ __('foodTypes') }}</span>
                </a>
            </li>
            <li data-toggle-tooltip="tooltip" title="Food List" data-placement="right">
                <a href="{{ url('admin/food') }}">
                    <i class="fa fa-list"></i>
                    <span class="xn-text">{{ __('typeAdminTitle') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="page-content" style="height: -webkit-fill-available;">
        <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
            <li class="xn-icon-button">
                <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
            </li>
            <li   class="xn-icon-button pull-right">
                <a href="/#" id="logoutBtn" class="mb-control" ><span class="fa fa-sign-out"></span></a>                        
            </li>
        </ul>
        <div class="page-content-wrap">
        @yield('content')                    
        </div>                            
    </div>
</div>
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
            <div class="mb-content">
                <p>{{ __('confirmLogout') }}</p>                    
                <p>{{ __('confirmLogout2') }}</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a href="{{ url('/logout') }}" class="btn btn-success btn-lg">{{ __('yes') }}</a>
                    <button class="btn btn-default btn-lg mb-control-close">{{ __('no') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('public')}}/js/plugins/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/plugins/bootstrap/bootstrap.min.js"></script>  
<script type='text/javascript' src="{{asset('public')}}/js/plugins/icheck/icheck.min.js"></script>        
<script type="text/javascript" src="{{asset('public')}}/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/plugins/scrolltotop/scrolltopcontrol.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/plugins/datatables/jquery.dataTables.min.js"></script> 
<script src="{{ asset('public/assets/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{asset('public')}}/js/plugins.js"></script>
<script type="text/javascript" src="{{asset('public')}}/js/actions.js"></script>
@if(session('success'))
<script type="text/javascript">
    $(document).ready(function(){
        var html = `
            <div class="col-md-2 mt-5 text-center notification noti-success">
                <p class="mt-3">
                    <i class="fa fa-check"></i>
                    <b id="notiMessage">This item has been remove!</b>
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
