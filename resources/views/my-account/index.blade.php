@extends('layouts.app')

@section('title', 'Minha conta - ')

@section('content')
	
	<div class="col col-md-9 px-0 mx-auto mt-5">
		<btn-install-pwa class="btn btn-outline-primary mb-2">Instalar aplicação</btn-install-pwa>

		<div class="card">
			<div class="card-header bg-primary">
				<h6 class="font-weight-bold text-white mb-0">
					<i class="fas fa-user-circle fa-fw mr-1"></i> Minha conta
				</h6>
			</div>

			<div class="card-body">
				<div>
					<div class="mb-4">
						<h6 class="font-weight-bold text-secondary">Nome </h6>
						<h5>{{ $user->fullname }}</h5>
					</div>

					<div class="mb-4">
						<h6 class="font-weight-bold text-secondary">E-mail</h6>
						<h5>{{ $user->email }}</h5>
					</div>

					<div class="mb-4">
						<h6 class="font-weight-bold text-secondary">Senha</h6>
						<h5>******</h5>
					</div>

					<div class="mb-4">
						<h6 class="font-weight-bold text-secondary">E-mail verificado em</h6>
						@if ($user->hasVerifiedEmail())
						<h5>{{ Helper::date($user->email_verified_at, '%d/%m/%Y') }}</h5>
						@else 
						<h5>Ainda não verificado</h5>
						@endif
					</div>

					<div class="mb-4">
						<h6 class="font-weight-bold text-secondary">Conta criada em</h6>
						<h5>{{ Helper::date($user->created_at, '%d/%m/%Y') }}</h5>
					</div>
				</div>

				<div class="d-flex justify-content-between text-center text-md-left flex-column flex-md-row">
					<a class="mb-2" href="#userModal" data-toggle="modal">
						<i class="fas fa-edit fa-fw mr-1"></i>Alterar dados
					</a>
					
					<a href="" class="text-danger">
						<i class="fas fa-trash-alt fa-fw mr-1"></i>Deletar minha conta
					</a>
				</div>
			</div>
		</div>
	</div>

	@include('my-account._modal-form')
@endsection