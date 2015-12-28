<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        @section('head')
        <title>RedminStore by Redooor</title>
        @show
    </head>
    <body>
        <header id="header">
            <div class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="{{ URL::to('/') }}" class="navbar-brand">{{ trans('redminstore::menus.brandname') }}</a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <?php $menu_pages = Redooor\Redminstore\App\Models\UI\Menu::getPages(); ?>
                        @if (count($menu_pages) > 0)
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('redminstore::menus.pages') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($menu_pages as $menu_page)
                                    <li><a href="{{ URL::to('page/' . $menu_page->slug) }}">{{ $menu_page->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        @endif
                        <?php $menu_posts = Redooor\Redminstore\App\Models\UI\Menu::getPosts(); ?>
                        @if (count($menu_posts) > 0)
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ trans('redminstore::menus.posts') }} <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach ($menu_posts as $menu_post)
                                    <li><a href="{{ URL::to('post/' . $menu_post->slug) }}">{{ $menu_post->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        @endif
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ url('/admin') }}">{{ trans('redminstore::menus.adminlogin') }}</a></li>
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
        
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

        @section('footer')
        @show
    </body>
</html>
