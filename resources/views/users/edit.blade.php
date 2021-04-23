@extends('layouts.app', [
'namePage' => 'Modifier utilisateur',
'class' => 'sidebar-mini',
'activePage' => 'users',
])
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

<style>
    .table-row {
        cursor: pointer;
    }

</style>

@stop

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Modifier les informations de l'utilisateur</h5>
                        <a class="btn btn-primary btn"
                            style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636"
                            href="{{ route('users.index') }}">Retoure</a>
                        </p>
                    </div>
                    @can('modifier utilisateur')
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                            </div>
                        </div><br>

                        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id]]) !!}
                        <div class="">

                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="fnWrapper">
                                    <label>Nom d'utilisateur: <span class="text-danger">*</span></label>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>Email: <span class="text-danger">*</span></label>
                                    {!! Form::text('email', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>

                        </div>
                        @foreach ($user->roles_name as $role)
                        @if ($role=='Client'||$role=='Vendeur')
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>Mot de passe <span class="text-danger">*</span></label>
                                {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>Confirmer le mot de passe: <span class="text-danger">*</span></label>
                                {!! Form::password('confirm-password', ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div> 
                        @endif 
                        @endforeach
                        <br>
                        <div class="row mg-b-20">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Type d'utilisateur</strong>
                                    <br>
                                    <br>
                                    {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="mg-t-30" style="align-items: center">
                            <button class="btn btn-main-primary pd-x-20" type="submit">Mettre à jour</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <!-- Bootstrap 4 -->
    {{-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $(".table-row").click(function() {
                window.document.location = $(this).data("href");
            });
        });

    </script>



    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var username = button.data('username')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
            modal.find('.modal-body #username').val(username);
        })

    </script>
@stop
