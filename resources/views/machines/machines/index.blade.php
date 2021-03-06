@extends('layouts.app', [
    'namePage' => 'Machines',
    'class' => 'sidebar-mini',
    'activePage' => 'Machines',
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
                @can('cr??e machine')
                <h3 class="card-title">
                  <a class="btn btn-primary btn-block" href="{{route('machines.create')}}" style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636">Ajouter une machines</a>
                </h3>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    @can('toutes les machine')

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style=" white-space: nowrap">
                    <th>id</th>
                    <th>Nom de la machines</th>
                    
                    <th>Etat de la machine</th>
                    <th>prix</th>
                    <th>Op??rations</th>
                    
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i=0?>
                    @foreach ($machines as $machine)
                    <?php $i++?>
                  <tr>
                    <td  class="table-row" data-href="machines/{{$machine->id}}">{{$i}}</td>
                    <td  class="table-row" data-href="machines/{{$machine->id}}">{{$machine->name}}</td>
                    <td  class="table-row" data-href="machines/{{$machine->id}}">{{$machine->state}}</td>
                    <td  class="table-row" data-href="machines/{{$machine->id}}">{{$machine->price}}</td>
                    <td >
                      @can('modifier machine')
                      <a class="btn btn-outline-info btn-sm" 
                      href= "{{route('machines.edit',$machine->id)}}"
                      role="button"><i class="fas fa-edit"></i>&nbsp;
                      Modifier</a>
                      @endcan
                      @can('effacer machine')
                      <button class="btn btn-outline-danger btn-sm"
                      data-toggle="modal"
                      
                      data-machine_id="{{ $machine->id }}"
                    
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
          <form action="{{ route('machines.destroy',$machine->id) }}" method="post">
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
	
		var machine_id = button.data('machine_id')
		var modal = $(this)
	
		modal.find('.modal-body #machine_id').val(machine_id);
	})
</script>

@stop