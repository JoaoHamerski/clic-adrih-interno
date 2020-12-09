<div class="card card-client">
	<div class="card-header bg-success text-white text-center">
		<h6 class="font-weight-bold mb-0">
			<i class="fas fa-user fa-fw mr-1"></i>Cliente
		</h6>
	</div>

	<div class="card-body">
		<h6 class="font-weight-bold text-secondary mb-1">Nome</h6>
		<div class="card-client-item-info">{{ $client->name }}</div>

		<hr>

		<h6 class="font-weight-bold text-secondary mb-1">Telefone</h6>
		<div class="card-client-item-info">{{ Mask::phone($client->getPhone()) ?? '[não informado]' }}</div>

		<hr> 

		<h6 class="font-weight-bold text-secondary mb-1">Endereço</h6>
		<div class="card-client-item-info">
			{{ $client->address ?? '[não informado]' }}

			@if ($client->city)
				<div class="font-weight-bold text-dark">
					{{ $client->city }}
				</div>
			@endif
		</div>

	</div>

	<hr class="my-0">

	<div class="card-body text-center">
		<div>
			<a href="#modalEditClient" data-toggle="modal">
				<i class="fas fa-user-edit fa-fw mr-1"></i>Editar dados
			</a>
		</div>

		<div class="my-2"></div>

		<div>
			<a class="text-danger" href=""><i class="fas fa-trash-alt fa-fw mr-1"></i>Deletar cliente</a>
		</div>
	</div>
</div>	

<modal id="modalEditClient" color="primary">
    <template #header>
      <i class="fas fa-user-edit fa-fw mr-1"></i>
      Alterar dados de cliente
    </template>

    <template #body>
      <div class="modal-body">
        @include('clients.form', ['edit' => true])
      </div>
    </template> 
  </modal>