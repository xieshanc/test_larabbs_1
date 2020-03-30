<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  {{-- CSRF Token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'LaraBBS') - {{ setting('site_name', '进阶') }}</title>
  <meta name="description" content="@yield('description', setting('seo_description'))">
  <meta name="keyword" content="@yield('keyword', setting('seo_keyword'))">


  <!-- Style -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  @yield('styles')
</head>

<body>
  <div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container">

      @include('shared._messages')

      @yield('content')

    </div>

    @include('layouts._footer')

  </div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
