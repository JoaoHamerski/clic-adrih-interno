@extends('layouts.app')

@section('title', 'Redefinir senha - ')

@section('content')
	<div class="col-md-5 mx-auto mt-5">
		<div class="card">
			<div class="card-header bg-primary text-white">
				<h6 class="font-weight-bold mb-0">Redefina sua senha</h6>
			</div>

			<div class="card-body">
				<div class="text-center mb-4 text-dark">
					<i class="fas fa-unlock-alt fa-4x"></i>
				</div>

				<reset-password-form inline-template>
					<form @submit.prevent="onSubmit"
						@keypress.prevent.enter="onSubmit"
						@focus.capture="clear($event.target.name)">

						<input ref="token" type="hidden" name="token" value="{{ $token }}">
						
						<md-input name="email" 
		                  label="E-mail"
		                  v-model="form.email"
		                  :disabled="true"
		                  :error-message="form.errors.get('email')"></md-input>

	                 	<md-input
		                  name="password" 
		                  label="Nova senha" 
		                  type="password"
		                  :autofocus="true"
		                  v-model="form.password"
		                  :error-message="form.errors.get('password')"></md-input>

		                <md-input
		                  name="password_confirmation" 
		                  label="Confirme a senha" 
		                  type="password"
		                  v-model="form.password_confirmation"></md-input>

		                <button :disabled="form.isLoading" class="btn btn-block btn-primary font-weight-bold">
                 			<span v-if="form.isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

		                	Alterar senha
		                </button>
					</form>
				</reset-password-form>
			</div>
		</div>
	</div>
@endsection