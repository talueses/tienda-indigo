@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Newsletter</h2>
      </div>


      <div class="card mb-3">
        <div class="card-header">Newsletter</div>

        <div class="card-body">


          <div class="clearfix mb-4">
              <div class="float-left">
                    <a class="text-primary mr-4" href="{{ route('newsletter.export') }}" style="cursor:pointer;text-decoration:underline;"><i class="fas fa-file-excel"></i> Descargar Excel</a>
              </div>
          </div>


          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Activo</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($emails as $email)
                    <tr>
                      <td>{{ $email->id }}</td>
                      <td>{{ $email->name }}</td>
                      <td>{{ $email->email }}</td>
                      <td> <input class="email_subscribe" type="checkbox" data-email-id="{{ $email->id }}" {{ $email->active ? 'checked':''}} /> </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>

      </div>
    </div>


@endsection


@section('scripts')
<script>
$('.email_subscribe').on('click', function(){

    var emailSub = $(this).is(':checked') ? 1 : 0;
    var emailId = $(this).data('email-id');

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "GET",
        url: "newsletter/subscribe",
        data: { active: emailSub, emailId: emailId }
    })
    .done(function(msg){
    });

});
</script>
@endsection
