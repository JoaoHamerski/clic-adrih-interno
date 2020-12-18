<template>
  <div class="modal fade" :id="id" tabindex="-1">
    <div class="modal-dialog" :class="[ modalDialogClass ]">
      <div class="modal-content">
        <div class="modal-header" :class="[ headerColor ]">
          <h6 class="modal-title font-weight-bold text-white">
            <slot name="header"></slot>
          </h6>

          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <slot name="body"></slot>

        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      id: {},
      color: {},
      modalDialogClass: {}
    },

    computed: {
      headerColor: function() {
        return 'bg-' + this.color;
      }
    },

    methods: {
      close() {
        $(this.$el).modal('hide');
      },
      focusRequestedElement(element) {
        let vm = this;

        element.$children.some(function(el) {
          if (el.autofocus == true) {
            el.focusInput();
            return true;
          }

          if (typeof el !=  'undefined') {
            vm.focusRequestedElement(el);
          }
        });
      }
    },

    mounted() {
        let vm = this;
        
        $('#' + this.id).on('shown.bs.modal', function(e) {
          vm.focusRequestedElement(vm);
        });
    }
  }
</script>