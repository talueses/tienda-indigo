@if(Session::has('message'))
    <div class="alert-message alert alert-{!!Session::get('message')['type']!!}">
        <a class="close" data-dismiss="alert">&times;</a>
        {!!Session::get('message')['message']!!}
    </div>
@endif


@if ($errors->any())
    <div class="alert-message alert alert-danger">
      <a class="close" data-dismiss="alert">&times;</a>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
