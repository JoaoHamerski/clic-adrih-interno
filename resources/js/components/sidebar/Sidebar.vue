<template>
  <div class="sidebar-wrapper" :class="{'is-active' : isActive}">
    <sidebar-button @click.native="toggleSidebar"></sidebar-button>

    <nav class="sidebar">
      <div class="header mt-3 px-3">
        <i class="fas fa-user-shield fa-3x mb-3"></i>

        <h5><slot name="username"></slot></h5>

        <hr style="border-color: rgba(255, 255, 255, .4)">
      </div>

      <div class="accordion accordion-sidebar">
        <ul class="list-group-flush list-unstyled">
          <slot></slot>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
  export default {
    props: {
      active: { type: Boolean, default: false }
    },
    data() {
      return {
        enableCookie: window.innerWidth > 766,
        isActive: this.active
      }
    },
    methods: {
      toggleSidebar() {
        this.isActive = ! this.isActive;

        if (this.enableCookie)
          this.setSidebarState(this.isActive);
      },
      getSidebarState() {
        return Cookies.get('sidebar-state') == 'true' ? true : false;
      },
      setSidebarState(state) {
        Cookies.set('sidebar-state', state);
      }
    },
    mounted() {
      if (this.enableCookie) {
        this.isActive = this.getSidebarState();
      }
    }
  }
</script>