@component('mail::layout')
  @slot('header')
    @component('mail::header', ['url' => 'https://interno.clicadrih.com/'])
      <img src="{{ url('images/clic-adrih-pink.png') }}" alt="Logo da loja Clic Adrih">
    @endcomponent
  @endslot
  
  # Olá

  Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.

  @component('mail::button', ['url' => $url, 'color' => 'primary'])
    Redefinir senha
  @endcomponent

  Este link de redefinição de senha expirará em {{ config('auth.passwords.users.expire') }} minutos

  Caso não tenha solicitado a redefinição de senha, você pode ignorar este e-mail.

  **Atenciosamente**,  
  Clic Adrih - Sistema Interno

  @component('mail::subcopy') 
  Caso tenha algum problema ao clicar no botão de redefinição de senha, acesse o link: <span class="break-all"><a href="{{ $url }}">{{ $url }}</a></span>
  @endcomponent

  @slot('footer')
    @component('mail::footer')
    Clic Adrih - Sistema Interno &bull; {{ Helper::date(\Carbon\Carbon::now(), '%d de %B de %Y') }}
    @endcomponent
  @endslot
@endcomponent