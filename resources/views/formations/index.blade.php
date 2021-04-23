@extends('layouts.app', [
    'namePage' => 'Formations',
    'class' => 'sidebar-mini',
    'activePage' => 'icons',
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
      {{-- VALIDATIONS HERE --}} 
      @if (session()->has('Add'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif

      @if (session()->has('edit'))
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
      @if (session()->has('delete'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
      
      
      @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
             </button>
          </div>
      @endif
                      {{-- VALIDATIONS HERE --}} 
                <h3 class="card-title">
                  @can('crée formation')
                  <a class="btn btn-primary btn-block" href="formations/create" style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636">ajouter une formation</a>
                  @endcan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @can('formations')
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style=" white-space: nowrap">
                    <th>id</th>
                    <th>Nom de la formation</th>
                    <th>Date de début</th>
                    <th>Prix</th>
                    <th>Opérations</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i=0?>
                    @foreach ($formations as $formation)
                    <?php $i++?>
                  <tr >
                    <td class="table-row" data-href="formations/{{$formation->id}}">{{$i}}</td>
                    <td class="table-row" data-href="formations/{{$formation->id}}">{{$formation->name}}</td>
                    <td class="table-row" data-href="formations/{{$formation->id}}">{{$formation->begin_date}}</td>
                    <td class="table-row" data-href="formations/{{$formation->id}}">{{$formation->price}}</td>
                    <td >
                      @can('modifier formation')
                      <a class="btn btn-outline-info btn-sm" 
                      href= "{{route('formations.edit',$formation->id)}}"
                      role="button"><i class="fas fa-edit"></i>&nbsp;
                      Modifier</a>
                      @endcan

                      @can('effacer formation')
                      <button class="btn btn-outline-danger btn-sm"
                      data-toggle="modal"
                      
                      data-formation_id="{{ $formation->id }}"
                    
                      data-target="#delete_file">
                      <i class="fas fa-trash"></i>&nbsp;Effacer</button>
                      @endcan
                    </td>
                  </tr>
                <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Supprimer la formation</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('formations.destroy',$formation->id) }}" method="post">
                      {{ method_field('delete') }}
                      {{ csrf_field() }}
                      <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red">Voulez-vous vraiment supprimer cette formation</h6>
                        </p>
            
                      
                        <input type="hidden" name="formation_id" id="formation_id" value="">
            
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
                @endcan
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
	
		var formation_id = button.data('formation_id')
		var modal = $(this)
	
		modal.find('.modal-body #formation_id').val(formation_id);
	})
</script>
@stop