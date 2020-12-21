@extends('layouts.app')

@section('content')
	
	<div class="col-md-8 mx-auto mt-5">
		<div class="card">
			<div class="card-header bg-primary text-white font-weight-bold">
				Envio de e-mail
			</div>
			<div class="card-body">
				<form action="/email" method="POST">
					@csrf
					<div class="form-group">
						<label for="email" class="font-weight-bold">E-mail</label>
						<input class="form-control" type="text" id="email" name="email">
					</div>

					<div class="form-group mt-5">
						<button class="btn btn-primary btn-block">Enviar</button>
					</div>
				</form>
			</div>
		</div>

	</div>
@endsection