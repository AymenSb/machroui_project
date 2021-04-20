@extends('layouts.app', [
    'namePage' => 'Modifier utilisateur',
    'class' => 'sidebar-mini',
    'activePage' => 'Users',
])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Modifier les informations de l'utilisateur</h5>
            <a class="btn btn-primary btn" style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636" href="{{ route('users.index') }}">Retoure</a>
            </p>
          </div>
          <div class="card-body">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                </div>
            </div><br>

            {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
            <div class="">

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6" id="fnWrapper">
                        <label>Nom d'utilisateur: <span class="text-danger">*</span></label>
                        {!! Form::text('name', null, array('class' => 'form-control','required')) !!}
                    </div>

                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>Email: <span class="text-danger">*</span></label>
                        {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                    </div>
                </div>

            </div>

            <div class="row mg-b-20">
                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                    <label>Mot de passe <span class="text-danger">*</span></label>
                    {!! Form::password('password', array('class' => 'form-control','required')) !!}
                </div>

                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                    <label>Confirmer le mot de passe: <span class="text-danger">*</span></label>
                    {!! Form::password('confirm-password', array('class' => 'form-control','required')) !!}
                </div>
            </div>


            <div class="row mg-b-20">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Type d'utilisateur</strong>
                        {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple'))
                        !!}
                    </div>
                </div>
            </div>
            <div class="mg-t-30" style="align-items: center">
                <button class="btn btn-main-primary pd-x-20" type="submit">Mettre à jour</button>
            </div>
            {!! Form::close() !!}
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection