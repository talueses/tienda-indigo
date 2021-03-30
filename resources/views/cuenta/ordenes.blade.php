@extends('layouts.front', ['subtitle'=>'Cuenta'])
@section('contenido')
@include('partials.banner')

<div class="container contenido">


  <div class="card">
    <div class="card-body customer-body">


          <div class="row no-gutters">

              <div class="col-md-3">

                @include('cuenta.partials.menu')

              </div>


                <div class="col-md-9">

                  <div class="" style="border-left: 1px solid #dfdfdf; min-height: 300px;">
                    <div class="card-body">

                        <h4 class="card-title">Mis ordenes</h4>

                        <div class="row">

                            <div class="col-md-12">
                                <!-- BEGIN ordenes --> 
                                <div class="table-responsive table-c-review">
                                  @include('cuenta.partials.ordenes')
                                </div>
                                <!-- END ordenes -->
                            </div>


                        </div>

                    </div>
                  </div>

                </div>


           </div>

    </div>
  </div>

</div>
@endsection
