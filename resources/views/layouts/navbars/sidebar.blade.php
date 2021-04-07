<div class="sidebar" data-color="red">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a  class="simple-text logo-mini">
      {{-- PLACE LOGO HERE --}}
    </a>
    <a href="/" class="simple-text logo-normal">
      {{ __('ADMIN PANEL') }}
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <li class="@if ($activePage == 'home') active @endif">
        <a href="{{ route('home') }}">
          <i class="now-ui-icons design_app"></i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li>
        <a data-toggle="collapse" href="#machines">
            <i class="fab fa-laravel"></i>
          <p>
            {{ __("Machines") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="machines">
          <ul class="nav">
            <li class="@if ($activePage == 'Machines') active @endif">
              <a href="{{ route('machines.index') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("Toutes les machines") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'test') active @endif">
              <a href="{{ route('profile.edit') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("Requêtes machines en attend") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'test') active @endif">
              <a href="{{ route('profile.edit') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("nouvelles machines") }} </p>
              </a>
            </li>
            <li class="@if ($activePage == 'users') active @endif">
              <a href="{{ route('profile.edit') }}">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p> {{ __("machines d'occasion") }} </p>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="@if ($activePage == 'icons') active @endif">
        <a href="{{ route('formations.index') }}">
          <i class="now-ui-icons education_atom"></i>
          <p>{{ __('Formations') }}</p>
        </a>
      </li>
      {{-- <li class = "@if ($activePage == 'maps') active @endif">
        <a href="{{ route('page.index','maps') }}">
          <i class="now-ui-icons location_map-big"></i>
          <p>{{ __('Maps') }}</p>
        </a>
      </li>
      <li class = " @if ($activePage == 'notifications') active @endif">
        <a href="{{ route('page.index','notifications') }}">
          <i class="now-ui-icons ui-1_bell-53"></i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class = " @if ($activePage == 'table') active @endif">
        <a href="{{ route('page.index','table') }}">
          <i class="now-ui-icons design_bullet-list-67"></i>
          <p>{{ __('Table List') }}</p>
        </a>
      </li>
      <li class = "@if ($activePage == 'typography') active @endif">
        <a href="{{ route('page.index','typography') }}">
          <i class="now-ui-icons text_caps-small"></i>
          <p>{{ __('Typography') }}</p>
        </a>
      </li> --}}
      
    </ul>
  </div>
</div>
