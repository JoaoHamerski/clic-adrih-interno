@component('mail::layout')
  @slot('header')
    @component('mail::header', ['url' => 'https://interno.clicadrih.com/'])
      {!! file_get_contents('images/clic-adrih.svg') !!}
    @endcomponent
  @endslot
  
  # Confirme seu e-mail

  Por favor, clique no botão abaixo para efetivar a confirmação da sua conta.

  @component('mail::button', ['url' => $verificationUrl, 'color' => 'primary'])
    VERIFICAR AGORA
  @endcomponent

  @slot('footer')
    @component('mail::footer')
    E-mail enviado automaticamente
    @endcomponent
  @endslot

  @component('mail::subcopy')
  Caso tenha algum problema ao clicar no botão de confirmação, acesse o link: <span class="break-all"><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></span>
  @endcomponent
@endcomponent