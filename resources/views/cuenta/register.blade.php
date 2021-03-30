@extends('layouts.front', ['subtitle'=>'Registro'])
@section('contenido')
@include('partials.banner')

    <div class="container">

        <div class="row">

            <div class="col-md-8 offset-md-2">

                <div class="card my-4">
                    <div class="card-body">

                        <h4 class="pb-3">Crear Cuenta</h4>

                        <form action="{{ route('customer.register') }}" method="post">
                            {{ csrf_field() }}

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <label>Nombres <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" minlength="3">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                    </span>
                                @endif
                                </div>
                                <div class="form-group col-md-6">
                                <label>Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="apellidos" value="{{ old('apellidos') }}" minlength="5">
                                @if ($errors->has('apellidos'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('apellidos') }}</small>
                                    </span>
                                @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>DNI <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="dni" value="{{ old('dni') }}">
                                @if ($errors->has('dni'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('dni') }}</small>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    </span>
                                @endif
                            </div>

                            <hr>

                            <div class="mb-4"></div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <label>Telefono 1 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telefono1" value="{{ old('telefono1') }}">
                                @if ($errors->has('telefono1'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('telefono1') }}</small>
                                    </span>
                                @endif
                                </div>
                                <div class="form-group col-md-6">
                                <label>Telefono 2</label>
                                <input type="text" class="form-control" name="telefono2" value="{{ old('telefono2') }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Dirección <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="direccion" value="{{ old('direccion') }}">
                                    @if ($errors->has('direccion'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('direccion') }}</small>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-3">
                                <label>País <span class="text-danger">*</span></label>
                                <select class="form-control" name="pais" id="pais">
                                    @if (count($paises)>0)                                        
                                        <option value="" selected>- Selecciona -</option>
                                        @foreach ($paises as $pais)
                                            <option value="{{ $pais->nombre }}" data-id="{{ $pais->id }}">{{ $pais->nombre }}</option>                                            
                                        @endforeach
                                    @else
                                            <option value="">- Sin registros -</option>
                                    @endif
                                    
                                </select>
                                @if($errors->has('pais'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('pais') }}</small>
                                    </span>
                                @endif
                                </div>
                                <div class="form-group col-md-3">
                                <label>Ciudad <span class="text-danger">*</span></label>
                                <select class="form-control" name="ciudad" id="ciudad"></select>
                                @if ($errors->has('ciudad'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('ciudad') }}</small>
                                    </span>
                                @endif
                                </div>
                            </div>
                            
                            <div class="row">
                                
                            <div class="form-group col-md-6">
                                <label>Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control subtitle"  name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('password') }}</small>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Ingrese Contraseña Nuevamente <span class="text-danger">*</span></label>
                                <input type="password" class="form-control subtitle"  name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
                                    </span>
                                @endif
                            </div>
                            </div>


                            <div class="mb-3">
                                <input type="checkbox" class="" id="acceptterms_register" name="accept_terms">
                                <label class="" for="acceptterms_register">Acepto los <a href="{{route('terminos')}}" target="_blank">términos y condiciones y política de privacidad</a></label>
                                @if ($errors->has('accept_terms'))
                                    <br>
                                    <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('accept_terms') }}</small>
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-outline-secondary linear w-50 py-2 my-2">Registrar</button>
                            </form>

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection

@section('javascript')
<script>
    console.log('sd')   

    $('#pais').change(function() {
        if($('#pais option:selected').val() !="") {
            let id=$('#pais option:selected').attr('data-id')  
            console.log(id)          
            const data = new FormData();
            data.append('id', id);    
           
            fetch('/api/department/list',{
                method:'post',
                body:data
            })               
                .then(res => res.json())
                .then(datos=>{
                    let options=''
                    if(datos.length>0){                        
                        for(let dat of datos){
                            $('#ciudad').html(options+=`<option value="${dat.nombre}" > ${dat.nombre}</option>`)                            
                        }
                        
                    }else{
                        $('#ciudad').html(
                            `<option value="" > - Sin registros - </option>`
                        )
                    }
                })
        }else {
            $('#ciudad').html(`<option value="" ></option>`)
        }
    });
</script>
@endsection