<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="{{ asset('js/vendor/lodash.core.js') }}"></script>

    <script src="https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit" async defer></script>
    <script>
        var new_question_recaptcha;
        var new_answer_recaptcha;
        var recaptchaCallback = function() {
            new_question_recaptcha = grecaptcha.render('new-question-recaptcha', {
                'sitekey' : '{{ env('RE_CAP_SITE') }}', //Replace this with your Site key
                'theme' : 'light'
            });

            new_answer_recaptcha = grecaptcha.render('new-answer-recaptcha', {
                'sitekey' : '{{ env('RE_CAP_SITE') }}', //Replace this with your Site key
                'theme' : 'dark'
            });
        };
    </script>

    <script type="text/javascript">
        var auth_id = "{{ Auth::id() }}";
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Навигация</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'CargoCentr.ru') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Войти</a></li>
                        <li><a href="{{ route('register') }}">Регистрация</a></li>
                    @else
                        <li>
                            <a href="#" data-toggle="modal" data-target="#new-question-modal">Создать вопрос</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выйти
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        @yield('content')

    </div>

    <footer class="footer top-buffer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a href="/ads">Реклама на сайте</a>
                    <!--a href="mailto:reklama@cargocentr.ru?subject=Реклама на сайте">Реклама на сайте</a-->
                </div>
            </div>
            <div class="row top-buffer-10">
                <div class="col-lg-4">
                    <div>&copy;&nbsp;@lang('messages.copyright')</div>
                    <div>@lang('messages.ip')</div>
                    <div>@lang('messages.inn')</div>
                    <div>@lang('messages.city')</div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/code.js') }}"></script>

<script>
    var ads = [];
    @for($i = 1; $i <= 11; $i++)
        ads[{{$i}}] = JSON.parse('{!! Ads::getBlock($i) !!}');
    @endfor
</script>

<script src="{{ asset('js/ads_controller.js') }}"></script>

@yield('scripts')

</body>
</html>
