@extends('layouts.app', [
    'namePage' => 'User',
    'class' => 'sidebar-mini',
    'activePage' => 'User',
])
@section('css')
      <!-- DataTables -->
      <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
      <!-- Google Font: Source Sans Pro -->
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   
    <style>
      .table-row{
cursor:pointer;
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
 
                <h3 class="card-title">
                  <a class="btn btn-primary" href="users/create" style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636">ajouter une utilisateur</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr style="text-align: center">
                            <th class="wd-10p border-bottom-0">#</th>
                            <th class="wd-15p border-bottom-0">Nom d'utilisateur</th>
                            <th class="wd-20p border-bottom-0">Email</th>
                            <th class="wd-15p border-bottom-0">Type d'utilisateur</th>
                            <th class="wd-10p border-bottom-0">Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                             

                                <td style="text-align: center">
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $v)
                                            <label class="badge badge-success" style="color: antiquewhite;">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>

                                <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info"
                                            title="edit"><i class="fas fa-pen"></i>&nbsp;&nbsp;Éditer</a>
                                    

                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-user_id="{{ $user->id }}" data-username="{{ $user->name }}"
                                            data-toggle="modal" href="#modaldemo8" title="delete"><i
                                                class="fas fa-trash"></i>&nbsp;&nbsp;Supprimer</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
      </div>
      
    </div>
    <div class="modal" id="modaldemo8">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content modal-content-demo">
              <div class="modal-header">
                  <h6 class="modal-title">Supprimer l'utilisateur</h6><button aria-label="Close" class="close"
                      data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
              </div>
              <form action="{{ route('users.destroy', 'test') }}" method="post">
                  {{ method_field('delete') }}
                  {{ csrf_field() }}
                  <div class="modal-body">
                      <p>êtes-vous sûr du processus de suppression?</p><br>
                      <input type="hidden" name="user_id" id="user_id" value="">
                      <input class="form-control" name="username" id="username" type="text" readonly>
                  </div>
                  <div class="modal-footer" style="">
                    <button type="submit" class="btn btn-danger">Confirmer</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                  </div>
          </div>
          </form>
      </div>
  </div>
  </div>
 
@stop

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
  $(function () {
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