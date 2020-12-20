<modal id="userModal" color="primary" modal-dialog-class="modal-dialog-centered">
	<template #header>
		<i class="fas fa-user-circle fa-fw mr-1"></i>
		Alterar dados
	</template>

	<template #body>
		<div class="modal-body">
			@include('my-account.form')
		</div>
	</template>
</modal>