<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>RedminStore by Redooor</title>
        <link rel="stylesheet" href="{{ URL::to('vendor/redooor/redminstore/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('vendor/redooor/redminstore/css/redmaterials.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('vendor/redooor/redminstore/css/redminstore.min.css') }}">
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="shortcut icon" type="image/png" href="{{ URL::to('vendor/redooor/redminstore/img/favicon.png') }}"/>
        @section('head')
        @show
    </head>
    <body>
        <header id="header">
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="{{ URL::to('admin') }}" class="navbar-brand">
                            <img src="{{ URL::to('vendor/redooor/redminstore/img/favicon.png') }}" title="RedminStore" class="brand-nav-logo"> RedminStore
                        </a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="{{ URL::to('/') }}">{{ Lang::get('redminstore::menus.home') }}</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ URL::to('logout') }}">{{ Lang::get('redminstore::menus.logout') }}</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->

                </div>
            </div>
        </header>

        <div id="main">
            <div class="container">
                @yield('content')
            </div>
        </div><!--End main-->
        
        <script src="{{ URL::to('vendor/redooor/redminstore/js/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::to('vendor/redooor/redminstore/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::to('vendor/redooor/redminstore/js/redmaterials.min.js') }}"></script>

        @section('footer')
        @show
    </body>
</html>
