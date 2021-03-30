@include ('admin.partials.header')

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand" href="{{ route('index') }}" target="_blank">Indigo <i class="fas fa-external-link-alt"></i></a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
 
    <div class="w-100">
      <div class="float-right">
        @include ('admin.partials.navbar')
      </div>  
    </div>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    @include ('admin.partials.sidebar')

    <div id="content-wrapper">

        @if(Session::has('message'))
          <div class="container-fluid">
            <div class="alert-message alert alert-{!!Session::get('message')['type']!!}">
                <a class="close" data-dismiss="alert">&times;</a>
                {!!Session::get('message')['message']!!}
            </div>
          </div>
        @endif
        @if ($errors->any())
          <div class="container-fluid">
            <div class="alert-message alert alert-danger">
              <a class="close" data-dismiss="alert">&times;</a>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
            </div>
          </div>
        @endif

        @yield ('content')

      <!--</div>-->
      <!-- /.container-fluid -->
      
      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <small>Copyright © Indigo {{ now()->year }}</small>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

@include ('admin.partials.footer')