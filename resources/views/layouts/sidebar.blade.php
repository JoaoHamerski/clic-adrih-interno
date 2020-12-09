<sidebar :enable-cookie="true" username="{{ Auth::user()->fullname }}">
  <sidebar-item
    icon="fa-users"
    icon-color="pink"
    href="{{ route('clients.index') }}"
    :active="{{ Request::is('clientes*') ? 'true' : 'false' }}">Clientes</sidebar-item>

  <sidebar-item
    icon="fa-boxes"
    icon-color="pink"
    href=""
    :active="{{ Request::is('pedidos*') ? 'true' : 'false' }}">Pedidos</sidebar-item>

  <hr class="my-2">

  <sidebar-item icon="fa-sign-out-alt" icon-color="pink" href="{{ route('auth.logout') }}">Sair</sidebar-item>
</sidebar>