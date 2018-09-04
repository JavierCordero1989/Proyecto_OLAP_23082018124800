<li class="{{ Request::is('encuestadores*') ? 'active' : '' }}">
    <a href="{!! route('encuestadores.lista-de-encuestas', Crypt::encrypt(Auth::user()->id)) !!}"><i class="fas fa-list-ul"></i><span> Mis encuestas</span></a>
</li>