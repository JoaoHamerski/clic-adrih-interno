<div class="card card-client">
	<div class="card-header bg-success text-white text-center">
		<h6 class="font-weight-bold mb-0">
			<i class="fas fa-user fa-fw mr-1"></i>Cliente
		</h6>
	</div>

	<div class="card-body position-relative">
		<dynamic-view id="clientDetails" 
			url="{{ route('clients.show.details', $client) }}"></dynamic-view>
	</div>

	<hr class="my-0">

	@if (Request::routeIs('clients.show'))
		<div class="card-body text-center">
			<div>
				<a href="#modalEditClient" data-toggle="modal">
					<i class="fas fa-user-edit fa-fw mr-1"></i>Editar dados
				</a>
			</div>

			<div class="my-2"></div>

			<div>
				<a class="text-danger" id="btnDeleteClient" href="">
					<i class="fas fa-trash-alt fa-fw mr-1"></i>Deletar cliente
				</a>
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
	@endif
</div>	

@push('script')
	<script>
		$('#btnDeleteClient').click(e => {
			e.preventDefault();

			swalModal.fire({
				title: 'Você tem certeza?',
				text: 'Isso excluirá o cliente, seus pedidos e pagamentos do sistema.',
				icon: 'warning',
			    iconHtml: '<i class="fas fa-exclamation-triangle"></i>',
			    iconColor: '#f69220'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	axios.delete(Vue.prototype.$helpers.getLocationURL() + '/delete')
			  		.then(response => {
			  			window.location.href = response.data.redirect;
			  		});
			  }
			});
		});
	</script>
@endpush
