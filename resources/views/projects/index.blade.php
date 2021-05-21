@extends('layouts.app', [
    'namePage' => 'Les projets',
    'class' => 'sidebar-mini',
    'activePage' => 'project',
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
                 @if (session()->has('add'))
                 <div class="alert alert-info alert-with-icon" data-notify="container">
                  <button type="button" aria-hidden="true" data-dismiss="alert" class="close">
                    <i class="now-ui-icons ui-1_simple-remove"></i>
                  </button>
                  <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                  <span data-notify="message">{{ session()->get('add') }}</span>
                </div>
                 @endif
                 @if (session()->has('updated'))
                 <div class="alert alert-info alert-with-icon" data-notify="container">
                  <button type="button" aria-hidden="true" data-dismiss="alert" class="close">
                    <i class="now-ui-icons ui-1_simple-remove"></i>
                  </button>
                  <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                  <span data-notify="message">{{ session()->get('updated') }}</span>
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
                @can('crée projet')
                <h3 class="card-title">
                  <a class="btn btn-primary btn-block" href="{{route('project.create')}}" style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636">Ajouter un projet</a>
                </h3>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    @can('projet')

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style=" white-space: nowrap">
                    <th>id</th>
                    <th>Nom du projet</th>
                    
                    <th>Type de projet</th>
                    
                    <th>Opérations</th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i=0?>
                    @foreach ($projects as $project)
                    <?php $i++?>
                  <tr>
                    <td  class="table-row" data-href="project/{{$project->id}}">{{$i}}</td>
                    <td  class="table-row" data-href="project/{{$project->id}}">{{$project->name}}</td>
                    <td  class="table-row" data-href="project/{{$project->id}}">{{$project->project_type}}</td>
                    <td >
                    
                      @can('effacer projet')
                      <button class="btn btn-outline-danger btn-sm"
                      data-toggle="modal"
                      
                      data-project_id="{{ $project->id }}"
                    
                      data-target="#delete_file">
                      <i class="fas fa-trash"></i>&nbsp;Effacer</button>
                      @endcan
                    </td>
                    
                  </tr>
                    <!-- delete image-->

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
          <form action="{{ route('project.destroy',$project->id) }}" method="post">
            {{ method_field('delete') }}
            {{ csrf_field() }}
            <div class="modal-body">
              <p class="text-center">
              <h6 style="color:red">Voulez-vous vraiment supprimer cette machine</h6>
              </p>
  
            
              <input type="text" name="project_id" id="project_id" value="">
  
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
	
		var project_id = button.data('project_id')
		var modal = $(this)
	
		modal.find('.modal-body #project_id').val(project_id);
	})
</script>

@stop