{{ HTML::style('assets/css/normalize.css') }}
{{ HTML::style('assets/css/foundation.min.css') }}
{{ HTML::style('assets/css/style.css') }}

{{ HTML::script('assets/js/vendor/modernizr.js') }}
{{ HTML::script('assets/js/vendor/jquery.js') }}
<link rel="icon" 
      type="image/png" 
      href="{{ asset('assets/img/favicon.png') }}">
@yield('custom-head')
