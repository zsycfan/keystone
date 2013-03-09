<html>
    <head>
      <script src="{{ path('/keystone/asset/js/app.min.js') }}"></script>
    </head>
    <body>
        @section('sidebar')
            
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>