<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>RedminStore by Redooor</title>
        <link rel="stylesheet" href="{{ URL::to('vendor/redooor/redminstore/css/jquery-ui/themes/blitzer/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('vendor/redooor/redminstore/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('vendor/redooor/redminstore/css/redmaterials.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('vendor/redooor/redminstore/css/redminstore.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('vendor/redooor/redminstore/css/datetimepicker/bootstrap-datetimepicker.min.css') }}">
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
                        {{ \Redooor\Redminstore\App\Helpers\Menu::rePrint(config('redminstore::menu'), 'nav navbar-nav') }}
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ URL::to('logout') }}">{{ Lang::get('redminstore::menus.logout') }}</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->

                </div>
            </div>
        </header>

        <div id="main">
            <div class="container">
                <div class="col-sm-3 col-md-2 sidebar">
                    
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    @yield('content')
                </div>
            </div>
        </div><!--End main-->

        <div id="confirm-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Confirm delete?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, no!</button>
                        <a href="#" id="confirm-delete" class="btn btn-danger">Yes, delete</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script src="{{ URL::to('vendor/redooor/redminstore/js/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::to('vendor/redooor/redminstore/js/moment/moment.min.js') }}"></script>
        <script src="{{ URL::to('vendor/redooor/redminstore/js/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::to('vendor/redooor/redminstore/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::to('vendor/redooor/redminstore/js/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ URL::to('vendor/redooor/redminstore/js/redmaterials.min.js') }}"></script>
        <script>
            !function ($) {
                $(function(){
                    $(document).on('click', '.btn-confirm', function(e) {
                        e.preventDefault();
                        $delete_url = $(this).attr('href');
                        $('#confirm-delete').attr('href', $delete_url);
                        $('#confirm-modal').modal('show');
                    });
                })
            }(window.jQuery);
        </script>

        @section('footer')
        @show
    </body>
</html>
