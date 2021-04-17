@extends('layouts.app', [
    'namePage' => 'Matiéres premiéres',
    'class' => 'sidebar-mini',
    'activePage' => 'Matiéres premiéres',
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
                  <a class="btn btn-primary btn-block" href="rawmaterials/create" style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636">Ajouter une nouvelle matière première</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style=" white-space: nowrap">
                    <th>id</th>
                    <th>Nom de la matière première</th>
                    <th>prix</th>
                    <th>Marque</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i=0?>
                    @foreach ($materials as $material)
                    <?php $i++?>
                  <tr >
                    <td class="table-row" data-href="rawmaterials/{{$material->id}}">{{$i}}</td>
                    <td class="table-row" data-href="rawmaterials/{{$material->id}}">{{$material->name}}</td>
                    <td class="table-row" data-href="rawmaterials/{{$material->id}}">{{$material->price}}</td>
                    <td class="table-row" data-href="rawmaterials/{{$material->id}}">{{$material->brand}}</td>
                    <td >
                     
                      
                      <button class="btn btn-outline-danger btn-sm"
                      data-toggle="modal"
                      
                      data-machine_id="{{ $material->id }}"
                    
                      data-target="#delete_file">
                      <i class="fas fa-trash"></i>&nbsp;Effacer</button>
                    </td>
                    
                   
                  </tr>
                  <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Supprimer la machine</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('rawmaterials.destroy',$material->id) }}" method="post">
                      {{ method_field('delete') }}
                      {{ csrf_field() }}
                      <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red">Voulez-vous vraiment supprimer cette machine</h6>
                        </p>
            
                      
                        <input type="hidden" name="machine_id" id="machine_id" value="">
            
                      </div>
                      <div class="modal-footer">
                                       <button type="submit" class="btn btn-danger">Confirmer</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        
                      </div>
                    </form>
                    
                  </div>
          
                </div>
                </div>
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

<script>
	$('#delete_file').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
	
		var machine_id = button.data('machine_id')
		var modal = $(this)
	
		modal.find('.modal-body #machine_id').val(machine_id);
	})
</script>
@stop