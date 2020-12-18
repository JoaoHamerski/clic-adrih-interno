<order-form :is-edit="{{ isset($edit) && $edit == true ? 'true' : 'false' }}" inline-template>
	<form @submit.prevent="onSubmit"
          @keypress.enter.prevent="onSubmit"
          @focus.capture="clear($event.target.name)">
		<h6 class="font-weight-bold text-secondary mb-3">Informações do pedido</h6>
		<div class="form-row d-flex flex-column flex-md-row">
			<md-input class="col"
		        name="name" 
		        label="Nome do pedido" 
		        v-model="form.name"
	            :autofocus="true"
		        :error-message="form.errors.get('name')"></md-input>

			<date-pick class="col" v-model="form.date" format="DD/MM/YYYY">
				<template v-slot="{toggle, inputValue}">
					<md-input :input-v-on="{focus: toggle}" v-model="form.date"
						name="date"
						placeholder="DD/MM/AAAA"
						label="Data"
						:btn-today="true"
						:input-group="true"
						:mask="$masks.date"
						:pipe="$masks.autoCorrectedDatePipe"
						autocomplete="off"
						:error-message="form.errors.get('date')"></md-input>
				</template>
			</date-pick>
		</div>

		<h6 class="font-weight-bold text-secondary mb-3">Informações de pagamento</h6>

    	<div class="mb-3">
    		@radios([
            'name' => 'paymentType',
            'disabled' => isset($edit) && $edit,
            'radios' => [
                [
                    'id' => 'cash',
                    'label' => 'Á vista',
                    'value' => 'in_cash',
                    'attributes' => [
                    	'v-model' => 'form.payment_type'                    
                    ]
                ],
                [
                    'id' => 'installment',
                    'label' => 'A prazo',
                    'value' => 'in_installment',
                    'attributes' => ['v-model' => 'form.payment_type']
                ]
            ]
        ])
    	</div>

    	<div v-show="form.payment_type == 'in_cash'">
    		<md-input
    			@input="form.price = $helpers.sanitizeMoney($event)"
		        name="price" 
		        label="Preço" 
		        v-model="form.masked_price"
		        :mask="$masks.valueBRL"
		        :error-message="form.errors.get('price')"></md-input>
    	</div>

    	<div v-show="form.payment_type == 'in_installment'">
    		<div>
    			<md-input
    				@input="toggleDisableInput('totalValue', 'installmentValue'); updateInstallmentValue()"
    				ref="totalValue"
    				name="totalValue"
    				label="Valor total"
    				v-model="totalValue"
    				:optional="true"
    				:disabled="isEdit"
    				disabled-message="Este campo é preenchido automaticamente"
    				:mask="$masks.valueBRL"></md-input>
    		</div>

    		<div v-if="! isEdit" class="form-row d-flex flex-column flex-md-row">
	    		<md-input class="col"
	    			@input="updateInstallmentValue(); updateTotalValue()"
	    			name="numberOfInstallments"
	    			label="Número de parcelas"
	    			v-model="numberOfInstallments"
	    			:mask="$masks.numericInt({integerLimit: 2})"></md-input>

	    		<date-pick class="col" v-model="dueInitialDate" format="DD/MM/YYYY">
					<template v-slot="{toggle}">
						<md-input :input-v-on="{focus: toggle}" v-model="dueInitialDate"
							placeholder="DD/MM/AAAA"
							label="Data"
							:input-group="true"
							:mask="$masks.date"
							:pipe="$masks.autoCorrectedDatePipe"></md-input>
					</template>
				</date-pick>

				<md-input class="col mb-1"
					@input="toggleDisableInput('installmentValue', 'totalValue'); updateTotalValue()"
					ref="installmentValue"
					name="installmentValue"
					label="Valor por parcela"
					v-model="installmentValue"
					disabled-message="Este campo é preenchido automaticamente"
					:mask="$masks.valueBRL"></md-input>	
			</div>

			<div class="mb-3"
				v-if="form.installments.length > 0">
				<small class="text-secondary">
					Ao alterar os campos acima, as parcelas serão atualizadas, sobrepondo os valores inseridos manualmente.
				</small>
			</div>

			<h6 class="font-weight-bold text-secondary mb-3" 
				v-if="form.installments.length > 0">
				Parcelas
			</h6>

			<div v-for="(installment, index) in form.installments" 
				class="form-row d-flex align-items-baseline">
				
				<h5 class="text-center font-weight-bold text-primary" style="width: 35px">
					@{{ index + 1 }}ª
				</h5>

				<md-input class="col"
					@input="updateTotalValueFromInstallments($event, index)"
					:name="`installments.${index}.value`"
					label="Valor"
					v-model="installment.masked_value"
					:mask="$masks.valueBRL"
					:disabled="installment.paid_at"
					disabled-message="Não é possível alterar parcelas já pagas"
					:error-message="form.errors.get(`installments.${index}.value`)">
					</md-input>

				<md-input class="col"
					:name="`installments.${index}.due_date`"
					label="Data de vencimento"
					v-model="installment.due_date"
					:mask="$masks.date"
					:pipe="$masks.autoCorrectedDatePipe"
					:keep-char-positions="true"
					:disabled="installment.paid_at"
					disabled-message="Não é possível alterar parcelas já pagas"
					:error-message="form.errors.get(`installments.${index}.due_date`)"></md-input>	

				<button class="btn btn-outline-danger" 
					:disabled="installment.paid_at"
					@click.prevent="deleteInstallment(index)">
					<i class="fas fa-trash-alt"></i>
				</button>
			</div>

			<div class="text-center my-3">
	    		<button @click.prevent="newInstallment()" class="btn btn-outline-primary">
	    			<i class="fas fa-plus fa-fw mr-1"></i>Nova parcela
	    		</button>
	    	</div>
    	</div>
    	

		<button :disabled="form.isLoading" type="submit" class="btn btn-success font-weight-bold">
			<span v-if="form.isLoading" class="spinner-border spinner-border-sm"></span>
			<span v-if="isEdit">Atualizar pedido</span>
    		<span v-else>Cadastrar pedido</span>
    	</button>
	</form>
</order-form>