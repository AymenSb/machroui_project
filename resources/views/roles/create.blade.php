@extends('layouts.app', [
'namePage' => 'Icons',
'class' => 'sidebar-mini',
'activePage' => 'icons',
])

@section('content')

    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}

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
                        <h5 class="title">Gestion des rôles</h5>
                        <a class="btn btn-primary btn"
                            style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636"
                            href="{{ route('roles.index') }}">Retoure</a>

                    </div>
                    @can('crée role')
                    <div class="card-body">
                        <div class="main-content-label mg-b-5">
                            <div class="col-xs-7 col-sm-7 col-md-7">
                                <div class="form-group">
                                    <p>Nom de rôle :</p>
                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <!-- col -->
                            <div class="col-lg-4">
                                <ul id="treeview1" class="text-info">
                                    <li><a class="text-info"><b>les Privilèges</b></a> <br><br>
                                        <ul>
                                    </li>
                                    @foreach ($permission as $value)
                                        <label
                                            style="font-size: 16px;">{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                                            {{ $value->name }}</label>

                                    @endforeach
                                    </li>

                                </ul>
                                </li>
                                </ul>
                            </div>
                            <!-- /col -->
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-info">Valider </button>
                            </div>

                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
