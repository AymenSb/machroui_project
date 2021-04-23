@extends('layouts.app', [
    'namePage' => 'Les rôles',
    'class' => 'sidebar-mini',
    'activePage' => 'roles',
])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Gestion des rôles</h5>
            @can('crée role')
            <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">Ajouter un rôle</a> 
            @endcan
          </div>
          @can('gestion des roles')
          <div class="card-body">
            <div class="table-responsive">
                <table class="table mg-b-0 text-md-nowrap table-hover ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                  @can('afficher role')
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('roles.show', $role->id) }}">Afficher</a>
                                  @endcan

                                  @can('modifier  role')
                                        <a class="btn btn-info btn-sm" 
                                            href="{{ route('roles.edit', $role->id) }}">Modifier</a>
                                  @endcan

                                  @can('supprimer role')
                                    @if ($role->name !== 'Admin')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                            $role->id], 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                                            {!! Form::close() !!}
                                    @endif
                                  @endcan



                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endcan
        </div>
      </div>
    </div>
  </div>
@endsection