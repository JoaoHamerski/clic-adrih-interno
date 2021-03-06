<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="/favicon.ico" type="image/png" sizes="16x16">
  <link rel="manifest" href="/manifest.webmanifest">
  <title>@yield('title')Clic Adrih</title>

  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @stack('css')
</head>

<body class="bg-light">
  <div id="app">
    @if (session()->exists('message'))
      <toast type="{{ session()->get('type') }}" message="{{ session()->get('message') }}"></toast>
    @endif
    
    <div class="wrapper">
      @auth
        @include('layouts.sidebar')
      @endauth

      <div class="content">
        @if (Auth::check() && ! Auth::user()->email_verified_at)
          <div class="bg-warning p-2">
            <h6 class="text-white text-center font-weight-bold ml-5 ml-md-0">
              Por favor, verifique seu email. Caso não tenha recebido o e-mail de verificação, 
              <a href="{{ route('email.send-verify') }}" class="font-weight-bold text-underline text-white">solicite novamente aqui</a>
            </h6>
          </div>
        @endif

        <div class="container">
          @yield('content')
        </div>
      </div>
    </div>
  </div>

  <script src="{{ mix('js/app.js') }}"></script>
  @stack('script')
</body>
</html>
