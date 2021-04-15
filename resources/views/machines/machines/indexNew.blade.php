@extends('layouts.app', [
    'namePage' => 'Machines',
    'class' => 'sidebar-mini',
    'activePage' => 'NewMachines',
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
                  <a class="btn btn-primary btn-block" href="{{route('machines.create')}}" style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636">Ajouter une machines</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style=" white-space: nowrap">
                    <th>id</th>
                    <th>Nom de la machines</th>
                    
                    <th>Etat de la machine</th>
                    <th>prix</th>
                    <th>Opérations</th>
                    
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i=0?>
                    @foreach ($Newmachines as $machine)
                    <?php $i++?>
                  <tr class="table-row" data-href="machines/{{$machine->id}}">
                    <td>{{$i}}</td>
                    <td>{{$machine->name}}</td>
                    <td>{{$machine->state}}</td>
                    <td>{{$machine->price}}</td>
                    <td>
                      <a class="btn btn-outline-info btn-sm" 
                      href= "{{route('editmachine',$machine->id)}}"
                      role="button"><i class="fas fa-edit"></i>&nbsp;
                      Modifier</a>
                      
                  <a class="btn btn-outline-warning btn-sm"
                      href= "deletethemachine/{{$machine->id}}"
                      role="button"><i
                          class="fas fa-trash"></i>&nbsp;
                      Supprimer</a>
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
@stop