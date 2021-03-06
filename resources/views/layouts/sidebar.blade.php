<sidebar :active="$helpers.isMdScreen()">
  <template #username>{{ Auth::user()->fullname }}</template>

  <sidebar-item
    icon="fa-users"
    icon-color="pink"
    href="{{ route('clients.index') }}"
    :active="{{ Request::is('clientes*') ? 'true' : 'false' }}">Clientes</sidebar-item>

  <sidebar-item
    icon="fa-boxes"
    icon-color="pink"
    href="{{ route('orders.index') }}"
    :active="{{ Request::is('pedidos*') ? 'true' : 'false' }}">Pedidos</sidebar-item>

  <sidebar-item
    icon="fa-user-circle"
    icon-color="pink"
    href="{{ route('my-account.show') }}"
    :active="{{ Request::is('minha-conta*') ? 'true' : 'false' }}">Minha conta</sidebar-item>

  <hr class="my-2">

  <sidebar-item 
    icon="fa-sign-out-alt" 
    icon-color="pink" 
    href="{{ route('auth.logout') }}">Sair</sidebar-item>
</sidebar>