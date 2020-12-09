@foreach($radios as $radio)
	<div class="custom-control custom-radio custom-control-inline">
		<input type="radio" 
			id="{{ $radio['id'] }}" 
			name="{{ $name }}"
			@isset($radio['value']) value="{{ $radio['value'] }}" @endisset
			@isset($radio['attributes']) {!! Helper::renderAttributes($radio['attributes']) !!} @endisset
			@if(isset($radio['checked']) && $radio['checked']) checked="checked" @endisset
			class="custom-control-input">

		<label class="custom-control-label" 
			for="{{ $radio['id'] }}">
			{{ $radio['label'] }}
		</label>
	</div>
@endforeach