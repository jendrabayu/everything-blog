<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}">
  <title>@yield('title', 'Home') - Everything Blog</title>
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Fonts -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="{{ asset('assets/css/mediumish.css') }}" rel="stylesheet">
  @stack('stylesheet')
</head>

<body>
  <!-- Begin Nav
================================================== -->
  <nav class="navbar navbar-toggleable-md navbar-light bg-white fixed-top mediumnavigation">
    @include('partials.navbar')
  </nav>
  <!-- End Nav
================================================== -->

  <!-- Begin Site Title
================================================== -->
  <div class="container">

    @yield('content')

    <!-- Begin Footer
 ================================================== -->
    <div class="footer">
      @include('partials.footer')
    </div>
    <!-- End Footer
 ================================================== -->

  </div>
  <!-- /.container -->

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
    integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous">
  </script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/ie10-viewport-bug-workaround.js') }}"></script>
  @stack('javascript')
</body>

</html>
