<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('public/assets/bootstrap/dist/css/bootstrap.min.css') }}" >   
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/homestyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/fontawesome/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/jquery/jquery-ui.min.css') }}" />
    <script src="{{ asset('public/js/plugins/jquery/jquery.min.js') }}" ></script>
    <script src="{{ asset('public/js/plugins/jquery/jquery-ui.min.js') }}" ></script>
</head>
<body style="background: url({{asset('public/images/39079980-food-wallpapers.jpg')}}) fixed no-repeat;">
        <div class="fixed-right mt-4 mr-3">
            <ul class="" id="menu-bar" style="list-style: none">
                <li class="mb-2">
                    <button class="btn btn-info btn-lg w-100 h-100 rounded-circle">
                        <i class="fa fa-home"></i>
                    </button>                   
                </li>
                <li class="mb-2">
                    <button class="btn btn-success btn-lg w-100 h-100 rounded-circle">
                        <i class="fa fa-user"></i>
                    </button>                   
                </li>
                <li class="mb-2">
                    <button class="btn btn-danger btn-lg w-100 h-100 rounded-circle">
                        <i class="fa fa-money"></i>
                    </button>                   
                </li>
                <li class="mb-2">
                    <button class="btn btn-warning btn-lg  w-100 h-100 rounded-circle">
                        <i class="fa fa-home"></i>
                    </button>                   
                </li>
                <li class="mb-2">
                    <button class="btn btn-primary btn-lg  w-100 h-100 rounded-circle">
                        <i class="fa fa-home"></i>
                    </button>                   
                </li>
            </ul>
        </div>
        
        @yield('homeMaster')

    <script src="{{ asset('public/assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>

</body>
</html>