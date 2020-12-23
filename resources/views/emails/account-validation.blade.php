@component('mail::layout')
  @slot('header')
    @component('mail::header', ['url' => 'https://interno.clicadrih.com/'])
      <img src="{{ url('images/clic-adrih-pink.png') }}" alt="Logo da loja Clic Adrih">
    @endcomponent
  @endslot
  
  # Confirme seu e-mail

  Por favor, clique no botão abaixo para fazer a confirmação do seu e-mail.

  @component('mail::button', ['url' => $verificationUrl, 'color' => 'primary'])
    VERIFICAR AGORA
  @endcomponent

  @component('mail::subcopy') 
  Caso tenha algum problema ao clicar no botão de confirmação, acesse o link: <span class="break-all"><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></span>
  @endcomponent

  @slot('footer')
    @component('mail::footer')
    Clic Adrih &bull; {{ Helper::date(\Carbon\Carbon::now(), '%d de %B de %Y') }}
    @endcomponent
  @endslot
@endcomponent