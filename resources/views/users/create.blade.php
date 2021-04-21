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
                        <div class="pull-left">
                            <a class="btn btn-primary btn-large" style="background-color: #FF3636"
                                href="{{ route('users.index') }}">Retoure</a>
                        </div>
                    </div>
                    @can('crées utilisateur')
                    <div class="card-body">
                        <br><br>
                        <div class="col-lg-12 margin-tb">

                        </div><br>
                        <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                            action="{{ route('users.store', 'test') }}" method="post">
                            {{ csrf_field() }}

                            <div class="">

                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <label>Nom d'utilisateur: <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm mg-b-20"
                                            data-parsley-class-handler="#lnWrapper" name="name" required="" type="text">
                                    </div>

                                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label>Email: <span class="text-danger">*</span></label>
                                        <input class="form-control form-control-sm mg-b-20"
                                            data-parsley-class-handler="#lnWrapper" name="email" required="" type="email">
                                    </div>
                                </div>

                            </div>

                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>Mot de passe : <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm mg-b-20"
                                        data-parsley-class-handler="#lnWrapper" name="password" required="" type="password">
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>Confirmez le mot de passe : <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm mg-b-20"
                                        data-parsley-class-handler="#lnWrapper" name="confirm-password" required=""
                                        type="password">
                                </div>
                            </div>

                            <div class="row mg-b-20">
                                <div class="col-xs-12 col-md-12">
                                    <div class="form-group">
                                        <label class="form-label" aria-required> Privilèges d'utilisateur</label>
                                        {!! Form::select('roles_name[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button class="btn btn-main-primary pd-x-20" type="submit">Confirmer</button>
                            </div>
                        </form>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
