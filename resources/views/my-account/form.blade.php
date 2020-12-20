<my-account-form :is-edit="true" inline-template>

	<form @submit.prevent="onSubmit"
          @keypress.enter.prevent="onSubmit"
          @focus.capture="clear($event.target.name)">
		<h6 class="text-secondary mb-3">Altere as suas informações cadastrais</h6>
		<md-input name="fullname"
			label="Nome"
			v-model="form.fullname"
			:error-message="form.errors.get('name')"
		></md-input>

		<md-input name="email"
			label="E-mail"
			v-model="form.email"
			:error-message="form.errors.get('email')"></md-input>

		<div class="form-row">
			<md-input class="col mb-1"
				name="password"
				label="Nova senha"
				v-model="form.password"
				type="password"
				autocomplete="no"
				:error-message="form.errors.get('password')"></md-input>

			<md-input class="col mb-1"
				name="password_confirmation"
				label="Confirme a senha"
				type="password"
				autocomplete="no"
				v-model="form.password_confirmation"></md-input>
		</div>

		<div class="small text-secondary mb-3">
			Deixe os campos de senha em branco caso não queira alterá-los.
		</div>		

		<div>
			<button type="submit" class="btn btn-success font-weight-bold">Salvar</button>
		</div>
	</form>
</my-account-form>