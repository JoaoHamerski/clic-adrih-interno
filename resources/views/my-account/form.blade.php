<my-account-form :is-edit="true" inline-template>

	<form @submit.prevent="onSubmit"
          @keypress.enter.prevent="onSubmit"
          @focus.capture="clear($event.target.name)">
		<h6 class="text-secondary mb-3">Altere as suas informações cadastrais</h6>
		<md-input name="fullname"
			label="Nome"
			v-model="form.fullname"
			:error-message="form.errors.get('fullname')"
		></md-input>

		<md-input name="email"
			label="E-mail"
			v-model="form.email"
			:error-message="form.errors.get('email')">
				<template #helper-message>
					<small class="form-text text-muted">
						Caso altere seu e-mail, um novo e-mail de confirmação será enviado.
					</small>
				</template>
			</md-input>

		<div class="form-row d-flex flex-column flex-md-row">
			<md-input class="col"
				name="password"
				label="Nova senha"
				v-model="form.password"
				type="password"
				autocomplete="new-password"
				:error-message="form.errors.get('password')">
					<template #helper-message>
						<small class="form-text text-muted">
							Deixa os campos de senha em branco caso não queira alterá-la
						</small>
					</template>
				</md-input>

			<md-input class="col"
				name="password_confirmation"
				label="Confirme a senha"
				type="password"
				autocomplete="new-password-confirmation"
				v-model="form.password_confirmation"></md-input>
		</div>

		<div>
			<button :disabled="form.isLoading" type="submit" class="btn btn-success font-weight-bold">
				<span v-if="form.isLoading" class="spinner-border spinner-border-sm"></span>
				Salvar
			</button>
		</div>
	</form>
</my-account-form>