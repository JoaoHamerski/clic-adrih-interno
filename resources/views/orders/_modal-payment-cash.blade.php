<modal id="modalPayment" color="primary" modal-dialog-class="modal-dialog-centered" 
	v-on:modal-closing="this.console.log('buceao')">
	<template #header>
		<i class="fas fa-dollar-sign fa-fw"></i>
		Efetuar pagamento
	</template>

	<template #body>
		<div class="modal-body">
			<order-cash-form v-on:form-submitted="$emit('modal-closing')" inline-template>
				<form @submit.prevent="onSubmit"
					@keypress.enter.prevent="onSubmit"
					@focus.capture="clear($event.target.name)">
					<h6 class="font-weight-bolder text-secondary mb-3">Informações do pagamento</h6>
					<md-input
						:autofocus="true"
				        name="value" 
				        label="Valor" 
				        v-model="form.value"
				        :mask="$masks.valueBRL"
				        :error-message="form.errors.get('value')"></md-input>

					<date-pick class="col px-0" v-model="form.date" format="DD/MM/YYYY">
						<template v-slot="{toggle, inputValue}">
							<md-input :input-v-on="{focus: toggle}" 
								v-model="form.date"
								placeholder="DD/MM/AAAA"
								label="Data"
								:btn-today="true"
								:input-group="true"
								:mask="$masks.date"
								:pipe="$masks.autoCorrectedDatePipe"
								:error-message="form.errors.get('date')"></md-input>
						</template>
					</date-pick>

			        <md-input
			        	name="note"
			        	label="Anotação"
			        	:optional="true"
			        	v-model="form.note"></md-input>

		        	<button class="btn btn-success font-weight-bold" 
		        		type="submit" 
		        		:disabled="form.isLoading">
						<span v-if="form.isLoading" class="spinner-border spinner-border-sm"></span>	
		        		Salvar
		        	</button>
				</form>
			</order-cash>
		</div>
	</template>
	
</modal>