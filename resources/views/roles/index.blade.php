@extends('layouts.app', [
    'namePage' => 'Icons',
    'class' => 'sidebar-mini',
    'activePage' => 'icons',
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
            <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">Ajouter un rôle</a> 
            
          </div>
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
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('roles.show', $role->id) }}">Afficher</a>
                                    
                                        <a class="btn btn-info btn-sm" 
                                            href="{{ route('roles.edit', $role->id) }}">Modifier</a>

                                    @if ($role->name !== 'Admin')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                            $role->id], 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                                            {!! Form::close() !!}
                                    @endif


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection