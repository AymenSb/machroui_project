<div class="sidebar" data-color="test">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
{{-- TO MODIFY COLORS public\assets\css\now-ui-dashboard.css --}}
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
        @can('machines')
        <a data-toggle="collapse" href="#machines">
          <i class="now-ui-icons users_single-02"></i>
          <p>
            {{ __("Machines") }}
            <b class="caret"></b>
          </p>
        </a>
        @endcan

        <div class="collapse" id="machines">
          <ul class="nav">
            @can('toutes les machine')
            <li class="@if ($activePage == 'Machines') active @endif">
              <a href="{{ route('machines.index') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("Toutes les machines") }} </p>
              </a>
            </li>
            @endcan
            
            @can('requetes des machines en attend')
            <li class="@if ($activePage == 'RequestedMachines') active @endif">
              <a href="{{ route('machinesrequests.index') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("Requêtes machines en attend") }} </p>
              </a>
            </li>
            @endcan
            @can('nouvelles machines')
            <li class="@if ($activePage == 'NewMachines') active @endif">
              <a href="{{ route('new') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("nouvelles machines") }} </p>
              </a>
            </li>
            @endcan

            @can('machines occasions')
            <li class="@if ($activePage == 'UsedMachines') active @endif">
              <a href="{{ route('used') }}">
                <i class="now-ui-icons design_bullet-list-67"></i>
                <p> {{ __("machines d'occasion") }} </p>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>


      <li>
        @can('formations')
        <a data-toggle="collapse" href="#formations">
          <i class="now-ui-icons users_single-02"></i>
          <p>
            {{ __("Formations") }}
            <b class="caret"></b>
          </p>
        </a>
        @endcan

        <div class="collapse" id="formations">
          <ul class="nav">
            <li class="@if ($activePage == 'formations') active @endif">
              <a href="{{ route('formations.index') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("Gestion des formations") }} </p>
              </a>
            </li>
            
            <li class="@if ($activePage == 'FormationsRequests') active @endif">
              <a href="{{ route('formations-requests.index') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("Demandes de formations") }} </p>
              </a>
            </li>
          </ul>
        </div>
      </li>

      @can('matières premières')
      <li class = " @if ($activePage == 'Matiéres premiéres') active @endif">
        <a href="{{ route('rawmaterials.index') }}">
          <i class="now-ui-icons ui-1_bell-53"></i>
          <p>{{ __('Matiéres premiéres') }}</p>
        </a>
      </li>
      @endcan
      @can('projet')
      <li class="@if ($activePage == 'project') active @endif">
        <a href="{{ route('project.index') }}">
          <i class="now-ui-icons education_atom"></i>
          <p>{{ __('Les projets') }}</p>
        </a>
      </li>
      @endcan
      @can('categories')
       <li class = "@if ($activePage == 'categories') active @endif">
        <a href="{{ route('category.index') }}">
          <i class="now-ui-icons location_map-big"></i>
          <p>{{ __('Categories') }}</p>
        </a>
      </li>
      @endcan
      
      @can('gestion des pubs')
      <li class = " @if ($activePage == 'Ads') active @endif">
        <a href="{{ route('ads.index') }}">
          <i class="now-ui-icons design_bullet-list-67"></i>
          <p>{{ __('Gestion des pubs') }}</p>
        </a>
      </li>
      @endcan
      
      @can('gestion des services')
      <li class = "@if ($activePage == 'Services') active @endif">
        <a href="{{ route('services.index') }}">
          <i class="now-ui-icons text_caps-small"></i>
          <p>{{ __('Gestion des services') }}</p>
        </a>
      </li> 
      @endcan
      
      <li>
        @can('gestion des utilisateurs')
        <a data-toggle="collapse" href="#users">
          <i class="now-ui-icons users_single-02"></i>
          <p>
            {{ __("Utilisateurs") }}
            <b class="caret"></b>
          </p>
        </a>
        @endcan
        <div class="collapse" id="users">
          <ul class="nav">
            @can('gestion des utilisateurs')
            <li class="@if ($activePage == 'users') active @endif">
              <a href="{{ route('users.index') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("Toutes les utilisateurs") }} </p>
              </a>
            </li>
            @endcan

            @can('gestion des roles')
            <li class="@if ($activePage == 'roles') active @endif">
              <a href="{{ route('roles.index') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("gestion des rôles") }} </p>
              </a>
            </li>
            @endcan
          
            
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
