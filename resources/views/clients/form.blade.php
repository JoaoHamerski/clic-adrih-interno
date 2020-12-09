<client-form :is-edit="{{ (isset($edit) && $edit == true) ? 'true' : 'false' }}" inline-template>
	<form @submit.prevent="onSubmit"
          @keypress.enter.prevent="onSubmit"
          @focus.capture="clear($event.target.name)">
		<h6 class="font-weight-bold text-secondary mb-3">Informações pessoais</h6>

		<md-input
	        name="name" 
	        label="Nome" 
	        v-model="form.name"
            :autofocus="true"
	        :error-message="form.errors.get('name')"></md-input>

	    <template v-for="(input, index) in form.phone">
	        <md-input
		        :name="`phone.${index}.number`" 
		        label="Telefone" 
		        :optional="true"
		        :input-group="true"
                :mask="$masks.phone"
		        v-model="input.number"
		        :error-message="form.errors.get(`phone.${index}.number`)">
		    	
		    	<template v-slot:input-append>
                    <div class="input-group-append">
    		    		<button v-if="input.is_main" 
    		    			@click.prevent="form.phone.push({ number: '' })" 
    		    			class="btn btn-outline-primary"
                            data-toggle="tooltip" title="Adicionar mais um telefone">
    		    			<i class="fas fa-plus"></i>
    		    		</button>

    		    		<button v-else class="btn btn-outline-danger" 
                            @click.prevent="form.phone.splice(index, 1)">
    		    			<i class="fas fa-trash-alt"></i>
    		    		</button>
                    </div>
		    	</template>    	
	        </md-input>
	    </template>

        <div class="mb-3">
            @radios([
                'name' => 'personType',
                'radios' => [
                    [
                        'id' => 'cpf',
                        'label' => 'Pessoa física',
                        'value' => 'cpf',
                        'attributes' => ['v-model' => 'form.person_type']
                    ],
                    [
                        'id' => 'cnpj',
                        'label' => 'Pessoa jurídica',
                        'value' => 'cnpj',
                        'attributes' => ['v-model' => 'form.person_type']
                    ]
                ]
            ])
        </div>

        <div class="form-row d-flex flex-column flex-md-row">
        	<md-input v-if="form.person_type == 'cpf'" class="col"
        		name="cpf"
        		label="CPF"
        		:optional="true"
                v-model="form.cpf"
                :mask="$masks.cpf"
        		:error-message="form.errors.get('cpf')"></md-input>

            <md-input v-else="form.person_type == 'cnpj'" class="col"
                name="cnpj"
                label="CNPJ"
                v-model="form.cnpj"
                :optional="true"
                :mask="$masks.cnpj"
                :error-message="form.errors.get('cnpj')"></md-input>
        </div>

        <h6 class="font-weight-bold text-secondary mb-3">Endereço</h6>

        <div class="form-row d-flex">
        	<md-input class="col"
        		name="city"
        		label="Cidade"
        		:optional="true"
        		v-model="form.city"
                default-value="Santo Ângelo"
        		:error-messsage="form.errors.get('city')"
        	></md-input>

        	<md-input class="col"
        		name="address"
        		label="Endereço"
        		:optional="true"
        		v-model="form.address"
        		:error-message="form.errors.get('address')"></md-input>
        </div>

        <div class="d-flex justify-content-between">
            <span v-if="form.errors.any()" class="d-inline-block disabled-tooltip" 
              tabindex="0" 
              data-toggle="tooltip" 
              title="Por favor, preencha os campos inválidos primeiro">
                <button :disabled="true" class="btn btn-success">
                    <span v-if="isEdit">Alterar dados</span>
                    <span v-else>Cadastrar cliente</span>
                </button>
            </span>

        	<button v-else :disabled="form.isLoading" type="submit" class="btn btn-success font-weight-bold">
        		<span v-if="form.isLoading" class="spinner-border spinner-border-sm"></span>

        		<span v-if="isEdit">Alterar dados</span>
                <span v-else>Cadastrar cliente</span>
        	</button>

        	<button class="btn btn-light" data-dismiss="modal">Cancelar</button>
        </div>
    </form>
</client-form>