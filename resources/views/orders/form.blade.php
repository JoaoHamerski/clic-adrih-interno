<order-form :is-edit="{{ isset($edit) && $edit == true ? 'true' : 'false' }}" inline-template>
	<form @submit.prevent="onSubmit"
          @keypress.enter.prevent="onSubmit"
          @focus.capture="clear($event.target.name)">
		<h6 class="font-weight-bold text-secondary mb-3">Informações do pedido</h6>
		<div class="form-row">
			<md-input class="col"
		        name="name" 
		        label="Nome do pedido" 
		        v-model="form.name"
	            :autofocus="true"
		        :error-message="form.errors.get('name')"></md-input>

	        <md-input class="col"
	        	name="date"
	        	label="Data do pedido"
	        	v-model="form.date"
	        	:mask="$masks.date"
	        	:pipe="$masks.autoCorrectedDatePipe"
	        	:keep-char-positions="true"
	        	:error-message="form.errors.get('date')"></md-input>
		</div>

		<h6 class="font-weight-bold text-secondary mb-3">Informações de pagamento</h6>

    	<div class="mb-3">
    		@radios([
            'name' => 'paymentType',
            'radios' => [
                [
                    'id' => 'cash',
                    'label' => 'Á vista',
                    'value' => 'in_cash',
                    'attributes' => ['v-model' => 'form.payment_type']
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
		        name="price" 
		        label="Preço" 
		        v-model="form.price"
		        :mask="$masks.valueBRL"
		        :error-message="form.errors.get('price')"></md-input>
    	</div>

    	<div v-show="form.payment_type == 'in_installment'">
    		<div>
    			<md-input
    				@input="toggleDisableInput('total_value', 'installment_value'); updateInstallmentValue()"
    				ref="total_value"
    				name="total_value"
    				label="Valor total"
    				v-model="total_value"
    				:optional="true"
    				disabled-message="Este campo é preenchido automaticamente"
    				:mask="$masks.valueBRL"></md-input>
    		</div>
    		<div class="form-row">
	    		<md-input class="col"
	    			@input="updateInstallmentValue(); updateTotalValue()"
	    			name="number_of_installments"
	    			label="Número de parcelas"
	    			v-model="number_of_installments"
	    			:mask="$masks.numericInt({integerLimit: 2})"></md-input>

				<md-input class="col"
					name="due_initial_date"
					label="Data primeira parcela"
					v-model="due_initial_date"
					:mask="$masks.date"
					:pipe="$masks.autoCorrectedDatePipe"
					:keep-char-positions="true"></md-input>

				<md-input class="col"
					@input="toggleDisableInput('installment_value', 'total_value'); updateTotalValue()"
					ref="installment_value"
					name="installment_value"
					label="Valor por parcela"
					v-model="installment_value"
					disabled-message="Este campo é preenchido automaticamente"
					:mask="$masks.valueBRL"></md-input>	
			</div>

			<h6 class="font-weight-bold text-secondary mb-3" v-if="form.installments.length > 0">Parcelas</h6>
			<div v-for="(installment, index) in form.installments" 
				class="form-row d-flex align-items-baseline">
				
				<h5 class="text-center font-weight-bold text-primary" style="width: 35px">
					@{{ index + 1 }}ª
				</h5>

				<md-input class="col"
					@input="updateTotalValueFromInstallments()"
					:name="`installments.${index}.value`"
					label="Valor"
					v-model="installment.value"
					:mask="$masks.valueBRL"
					:error-message="form.errors.get(`installments.${index}.value`)">
					</md-input>

				<md-input class="col"
					:name="`installments.${index}.due_date`"
					label="Data de vencimento"
					v-model="installment.due_date"
					:mask="$masks.date"
					:pipe="$masks.autoCorrectedDatePipe"
					:keep-char-positions="true"
					:error-message="form.errors.get(`installments.${index}.due_date`)"></md-input>	
			</div>
    	</div>


    	<button type="submit" class="btn btn-success font-weight-bold">
    		Cadastrar pedido
    	</button>
	</form>
</order-form>