@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
	<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.6/dropzone.min.css">

@endsection

@section('content')
	<div class="container">
		<h1 class="text-center mt-4">Registrar Establecimeinto</h1>
		<div class="row mt-4 justify-content-center">
			<form 
				method="post" 
				action="{{ route('establecimiento.store') }}" 
				class="col-md-9 card card-body" 
				enctype="multipart/form-data">
				@csrf	
				<input type="hidden" id="uuid" name="uuid" value="{{ Str::uuid()->toString() }}">			
				<fieldset class="border p-4">
					<legend class="text-primary font-weight-bold">Nombre, Categoria e Imagen principal</legend>
					<div class="form-group">
						<label for="nombre">Nombre Establecimeinto</label>
						<input 
							type="text" 
							class="form-control @error('nombre') is-invalid @enderror" 
							id="nombre"
							placeholder="Nombre del establecimiento"
							name="nombre"
							value="{{ old('nombre') }}">

						@error('nombre')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="categoria">Categoria</label>
						<select 
							class="custom-select @error('categoria') is-invalid @enderror"
							name="categoria"
							id="categoria">
							<option value="" selected disabled>---Seleccione---</option>
							@foreach($categorias as $id => $categoria)
								<option 
									value="{{ $id }}"
									{{ old('categoria') == $id? 'selected' : '' }}>
									{{ $categoria }}</option>
							@endforeach
							
						</select>

						@error('categoria')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="imagen_principal">Imagen Principal</label>
						<input 
							type="file" 
							class="form-control @error('imagen_principal') is-invalid @enderror" 
							id="imagen_principal"							
							name="imagen_principal"
							value="{{ old('imagen_principal') }}">

						@error('imagen_principal')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
				</fieldset>

				<fieldset class="border p-4 mt-4">
					<legend class="text-primary font-weight-bold">Ubicaci??n</legend>
					<div class="form-group">
						<label for="nombre">Coloca la direcci??n del establecimiento</label>
						<input 
							type="text" 
							class="form-control" 
							id="formbuscador"
							placeholder="Calle del negocio o establecimiento"
							>
						<p class="text-secondary mt-4 mb-3 text-center">
							El asistente colocar?? una direcci??n estimada mueve el pin al lugar correcto
						</p>
					</div>
					<div class="form-group">
						<div id="mapa" style="height: 400px"></div>
					</div>

					<p class="informacion">
						confirma que los siguientes campos son correctos
						@error('lat')
							<span class="invalid-feedback d-inline ml-5">Selecciona tu ubicaci??n en el mapa</span>
						@enderror
					</p>
					<div class="form-group">
						<label for="direccion">Direcci??n</label>
						<input 
							type="text"
							id="direccion"
							name="direccion"
							class="form-control @error('direccion') is-invalid @enderror"
							placeholder="Direcci??n"
							value="{{ old('direccion') }}">

						@error('direccion')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror							
					</div>

					<div class="form-group">
						<label for="direccion">Colonia</label>
						<input 
							type="text"
							id="colonia"
							name="colonia"
							class="form-control @error('colonia') is-invalid @enderror"
							placeholder="Direcci??n"
							value="{{ old('colonia') }}">

						@error('colonia')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror							
					</div>
					<input type="hidden" name="lat" id="lat" value="{{ old('lat') }}">
					<input type="hidden" name="lng" id="lng" value="{{ old('lng') }}">										
				</fieldset>

				<fieldset class="border p-4 mt-4">
					<legend class="text-primary font-weight-bold">Informaci??n del establecimiento</legend>
					<div class="form-group">
						<label for="telefono">Tel??fono</label>
						<input 
							type="text" 
							class="form-control @error('telefono') is-invalid @enderror" 
							id="telefono"
							placeholder="Tel??fono del establecimiento"
							name="telefono"
							value="{{ old('telefono') }}">

						@error('telefono')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="categoria">Descripci??n</label>
						<textarea
							class="form-control @error('descripcion') is-invalid @enderror" 
							name="descripcion"
							id="descripcion"
							placeholder="Breve descripcion del establecimiento"
							cols="4">{{ old('descripcion') }}</textarea>						

						@error('descripcion')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="apertura">Hora Apertura</label>
						<input 
							type="time" 
							class="form-control @error('apertura') is-invalid @enderror" 
							id="apertura"							
							name="apertura"
							value="{{ old('apertura') }}">

						@error('apertura')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="cierre">Hora cierre</label>
						<input 
							type="time" 
							class="form-control @error('cierre') is-invalid @enderror" 
							id="cierre"							
							name="cierre"
							value="{{ old('cierre') }}">

						@error('cierre')
							<div class="invalid-feedback">
								{{ $message }}
							</div>
						@enderror
					</div>
				</fieldset>

				<fieldset class="border p-4 mt-4">
					<legend class="text-primary">Galer??a de Imag??nes</legend>
					<div class="form-group">
						<label for="imagenes">Im??genes</label>
						<div id="dropzone" class="dropzone form-control"></div>
					</div>
					
				</fieldset>
				<input class="btn btn-primary mt-3 d-block" type="submit" value="Registrar Establecimeinto">
			</form>
 	</div>

@endsection

@section('scripts')
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" 
	 integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>	
	<script src="https://unpkg.com/esri-leaflet" defer></script>	
    <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.6/dropzone.min.js" defer></script>

@endsection