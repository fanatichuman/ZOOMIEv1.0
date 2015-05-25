<html>
    <head>
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/assets/css/public.css" />
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::Route('home')}}">Loki</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

              <li> <a href="/?toggle-doubles=1" >Toggle Doubles <?= (Session::get('doubles')) ? ' - active -' : ''?></a> </li>

            </ul>

          </div><!-- /.navbar-collapse -->
        </nav>

        @yield('content')
        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/assets/js/public.js"></script>
    </body>
</html>
