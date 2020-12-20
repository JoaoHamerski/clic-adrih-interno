@extends('layouts.app')

@section('title', 'Minha conta - ')

@section('content')
	
	<div class="col col-md-9 px-0 mx-auto">
		<div class="card mt-5">
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
						<h6 class="font-weight-bold text-secondary">Conta criada em</h6>
						<h5>{{ Helper::date($user->created_at, '%d/%m/%Y') }}</h5>
					</div>
				</div>

				<div class="d-flex justify-content-between">
					<a href="#userModal" data-toggle="modal"><i class="fas fa-edit fa-fw mr-1"></i>Alterar dados</a>
					
					<a href="" class="text-danger">
						<i class="fas fa-trash-alt fa-fw mr-1"></i>Deletar minha conta
					</a>
				</div>
			</div>
		</div>
	</div>

	@include('my-account._modal-form')
@endsection