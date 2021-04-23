@extends('layouts.app', [
'namePage' => 'Les rôles',
'class' => 'sidebar-mini',
'activePage' => 'roles',
])

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Erreur</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Modifier le rôle</h5>
                        <a class="btn btn-primary btn"
                            style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636"
                            href="{{ route('roles.index') }}">Retour</a>

                        </p>
                    </div>
                    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
                    @can('modifier  role')
                    <div class="card-body">
                        <div class="main-content-label mg-b-5">
                            <div class="form-group">
                                <p>Nom de rôle :</p>
                                {!! Form::text('name', json_decode(json_encode($role->name)), ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                            </div>
                        </div><br><br>
                        <div class="row">
                            <!-- col -->
                            <div class="col-lg-4">
                                <ul id="treeview1">
                                    <li class="text-info"><a class="text-info">Privilèges</a>
                                        <ul>

                                            @foreach ($permission as $value)
                                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name']) }}
                                                    {{ $value->name }}</label>
                                                <br />
                                            @endforeach


                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-info">Mettre à jour</button>
                            </div>
                            <!-- /col -->
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
