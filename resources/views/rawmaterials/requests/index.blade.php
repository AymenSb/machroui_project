@extends('layouts.app', [
    'namePage' => 'Les demandes des matières premières',
    'class' => 'sidebar-mini',
    'activePage' => 'MaterialsRequests',
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
            @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>{{ session()->get('Add') }}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
            <h5 class="title">Les demandes du matières premières</h5>
          </div>
          <div class="card-body">
            @can('formations')
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr style=" white-space: nowrap">
                <th>id</th>
                <th>Nom du client</th>
                <th>Email du client</th>
                <th>Numéro du client</th>
                <th>Matière première</th>
                <th>Opérations</th>
              </tr>
              </thead>
              <tbody>
                <?php $i=0?>
                @foreach ($requests as $request)
                <?php $i++?>
              <tr >
                <td >{{$i}}</td>
                <td >{{$request->client_name}} {{$request->client_surname}}</td>
                <td >{{$request->client_email}}</td>
                <td >{{$request->client_number}}</td>
                <td >{{$request->material->name}}</td>
                <td >
                  <button class="btn btn-outline-info btn-sm"
                  data-toggle="modal"
                  
                  data-request_id="{{ $request->id }}"
                
                  data-target="#accept_request">
                  <i class="fas fa-check"></i>&nbsp;Accepter</button>

                  @can('effacer formation')
                  <button class="btn btn-outline-danger btn-sm"
                  data-toggle="modal"
                  
                  data-request_id="{{ $request->id }}"
                
                  data-target="#delete_file">
                  <i class="fas fa-times"></i>&nbsp;Refuser</button>
                  @endcan
                </td>
              </tr>
            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Supprimer la requête</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ route('rawmaterials-requests.destroy',$request->id) }}" method="post">
                  {{ method_field('delete') }}
                  {{ csrf_field() }}
                  <div class="modal-body">
                    <p class="text-center">
                    <h6 style="color:red">Voulez-vous vraiment supprimer cette requête</h6>
                    </p>
        
                  
                    <input type="hidden" name="request_id" id="request_id" value="">
        
                  </div>
                  <div class="modal-footer">
                                   <button type="submit" class="btn btn-danger">Confirmer</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    
                  </div>
                </form>
                
              </div>
      
              </div>
            </div>


          <div class="modal fade" id="accept_request" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Accepter la demande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('rawmaterials-requests.edit',$request->id) }}" >
                <div class="modal-body">
                  <p class="text-center">
                  <h6 style="color:green">Voulez-vous vraiment accepter cette demande</h6>
                  </p>
      
                
                  <input type="hidden" name="request_id" id="request_id" value="">
      
                </div>
                <div class="modal-footer">
                                 <button type="submit" class="btn btn-success">Confirmer</button>
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
	$('#accept_request').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
	
		var request_id = button.data('request_id')
		var modal = $(this)
	
		modal.find('.modal-body #request_id').val(request_id);
	})
</script>

<script>
	$('#delete_file').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
	
		var request_id = button.data('request_id')
		var modal = $(this)
	
		modal.find('.modal-body #request_id').val(request_id);
	})
</script>
@stop