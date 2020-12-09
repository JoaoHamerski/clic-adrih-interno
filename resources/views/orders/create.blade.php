@extends('layouts.app')

@section('title', 'Novo pedido - ')

@section('content')
	<div class="mt-5 mb-2 col-md-9 mx-auto">
		<a href="{{ $client->path() }}" class="btn btn-outline-primary">
			<i class="fas fa-arrow-alt-circle-left fa-fw mr-1"></i>Voltar
		</a>
	</div>

	<div class="col-md-9 mx-auto">
		<div class="card">
			<div class="card-header bg-primary">
				<h6 class="text-white font-weight-bold mb-0">
					<i class="fas fa-box fa-fw mr-1"></i> Novo pedido para {{ $client->name }}
				</h6>
			</div>

			<div class="card-body">
				@include('orders.form')
			</div>
		</div>
	</div>
@endsection