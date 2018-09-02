<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{url('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/massagem/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{url('assets/massagem/default/media/img/logo/favicon.ico')}}" />
</head>

<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
            <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
                <div class="m-stack m-stack--hor m-stack--desktop">
                    <div class="m-stack__item m-stack__item--fluid">
                        <div class="m-login__wrapper">
                            <div class="m-login__logo">
                                <a href="#">
                                    <img src="{{url('assets/app/media/img/logos/logo-2.png')}}">
                                </a>
                            </div>
                            <div class="m-login__signin">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">
                                        Entrar no admin
                                    </h3>
                                </div>
                                <form method="POST" action="{{ route('login') }}" class="m-login__form m-form">
                                    @csrf
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input" type="text" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Senha" name="password">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="row m-login__form-sub">
                                        <div class="col m--align-left">
                                            <label class="m-checkbox m-checkbox--focus">
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                Lembrar-me
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col m--align-right">
                                            <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                                Esqueceu sua senha?
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-login__form-action">
                                        <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                            Entrar
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="m-login__forget-password">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">
                                        Esqueceu sua senha?
                                    </h3>
                                    <div class="m-login__desc">
                                        Entre com seu email para recuperar sua senha:
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('password.email') }}" class="m-login__form m-form">
                                    @csrf
                                    <div class="form-group m-form__group">
                                        <input class="form-control m-input" type="text" placeholder="Email" name="email" value="{{ old('email') }}" id="m_email" autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="m-login__form-action">
                                        <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">
                                            Enviar
                                        </button>
                                        <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url({{url('assets/app/media/img/bg/bg-1.jpg')}})">
                <div class="m-grid__item m-grid__item--middle">
                    <h3 class="m-login__welcome">
                        Título de impacto
                    </h3>
                    <p class="m-login__msg">
                        Lorem ipsum dolor sit amet, coectetuer adipiscing
                        <br>
                        elit sed diam nonummy et nibh euismod
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <script src="{{url('assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/massagem/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/snippets/custom/pages/user/login.js')}}" type="text/javascript"></script>
</body>
</html>
