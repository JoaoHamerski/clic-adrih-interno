<h6 class="font-weight-bold text-secondary mb-1">Nome</h6>
<div class="card-client-item-info">{{ $client->name }}</div>

<hr>

<h6 class="font-weight-bold text-secondary mb-1">Telefone</h6>
<div class="card-client-item-info">{{ Mask::phone($client->getPhone()) ?? '[não informado]' }}</div>

@if (! $client->getSecondaryPhones()->isEmpty())
	<span class="small text-primary clickable" 
		data-toggle="tooltip" 
		data-html="true" 
		data-title="
		<ul class='list-unstyled mb-0'>
		@foreach($client->getSecondaryPhones() as $phone) 
			<li>{{ \Mask::phone($phone) }}</li>
		@endforeach
		</ul>
		">(secundários)</span>
@endif

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

<hr>

<div class="{{ $client->getTotalOwing() > 0 ? 'text-danger' : 'text-success' }}">
	<h6 class="font-weight-bold">
		Total devendo
	</h6>
	<div class="card-client-item-info">
		{{ Mask::money($client->getTotalOwing()) }}
	</div>
</div>