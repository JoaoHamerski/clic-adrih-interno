<template>
	<div class="form-group form-material-group" :class="{ 'active' : isActive }">	
		<div :data-toggle="isDisabled ? 'tooltip' : false"
			:title="isDisabled ? disabledMessage : false" 
			:class="{'input-group': showInputGroup || btnToday}">

			<masked-input class="form-control"
				ref="maskedInput" 
				:class="{ 'is-invalid' : isInvalid }"
				:type="inputType" 
				:id="id"
				:disabled="isDisabled"
				:autocomplete="autocomplete"
				:name="name"
				:value="value"
				:placeholder="placeholder"
				:mask="mask"
				:pipe="pipe"
				:keep-char-positions="keepCharPositions"
				:guide="false"
				v-on="inputVOn"
				@input="$emit('input', $event);">
			</masked-input>

			<label v-if="label" :for="id">{{ label }} 
				<small class="optional" v-if="optional">(opcional)</small>
			</label>

			<div v-if="showPasswordButton" class="input-group-append">
				<button tabindex="-1" @click.prevent="togglePasswordType(); focusInput();" 
					class="btn btn-outline-primary">
					<i v-if="inputType == 'text'" class="fas fa-eye fa-fw"></i>
					<i v-else class="fas fa-eye-slash fa-fw"></i>
				</button>
			</div>

			<div v-if="btnToday" class="input-group-append">
				<button class="btn btn-outline-primary" @click.prevent="today()">HOJE</button>
			</div>

			<slot name="input-append"></slot>
		</div>

		<small class="text-danger" v-if="isInvalid">{{ errorMessage }}</small>

		<slot name="helper-message"></slot>
	</div>
</template>

<script>
	import MaskedInput from 'vue-text-mask';

	export default {
		components: { MaskedInput },
		props: {
			id: {},
			autocomplete: { default: false },
			inputVOn: { default: false },
			name: {}, 
			btnToday: {},
			label: {}, 
			value: {},
			disabled: { default: false },
			disabledMessage: {},
			mask: { default: false },
			pipe: {},
			keepCharPositions: { default: false },
			type: { default: 'text'}, 
			autofocus: {},
			placeholder: {}, 
			errorMessage: {},
			optional: { type: Boolean },
			hasError: { type: Boolean },
			inputGroup: { type: Boolean }
		},
		data () {
			return {
				isDisabled: this.disabled,
				inputType: this.type,
				showPasswordButton: (this.type == 'password')
			}
		},
		computed: {
			showInputGroup: function() {
				return this.inputGroup || this.showPasswordButton;
			},
			isInvalid: function() {
				return (this.hasError || ! this.$helpers.isEmpty(this.errorMessage));
			},
			isActive: function() {
				return ! this.$helpers.isEmpty(this.value);
			}
		},
		methods: {
			togglePasswordType() {
				this.inputType = (this.inputType == 'password' ? 'text' : 'password');
			},
			focusInput() {
				let input = this.$refs.maskedInput.$el,
					length = input.value.length;

				input.focus();

				this.$nextTick(() => { input.setSelectionRange(length, length) });
			},
			today() {
				let today = moment().format('DD/MM/YYYY');
				this.$refs.maskedInput.$emit('input', today);
			}
		},
		mounted() {
			if (this.autofocus) {
				this.focusInput();
			}
		}
	}
</script>