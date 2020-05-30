<!doctype html>
<html lang="pt-BR">
    <head>

        <meta charset="utf-8">

          
        

        <title>Restaurantes</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway';
                font-weight: 100;
                height: 100vh;
                margin: 0;
                display: flex;
            }

            .full-height {
                height: 100vh;
            }

            .position-ref {
                position: relative;
            }

            .text-center {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .h2-style {
                color: #000 !important;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }


        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">

                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
   
