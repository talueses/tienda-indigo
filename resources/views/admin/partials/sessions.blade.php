@if(Session::has('message'))
    <div class="alert-message alert alert-info">
        <a class="close" data-dismiss="alert">&times;</a>
        {!!Session::get('message')!!}
    </div>
@endif