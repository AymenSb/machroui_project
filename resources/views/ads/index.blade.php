@extends('layouts.app', [
    'namePage' => 'Publicités',
    'class' => 'sidebar-mini',
    'activePage' => 'Ads',
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
                @can('crée pub')
                <h3 class="card-title">
                  <a class="btn btn-primary btn-block" href="ads/create" style="width: 260px; padding: 10px 32px; font-size: 16px;background-color:#FF3636">ajouter une publicité</a>
                </h3>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @can('gestion des pubs')
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr style=" white-space: nowrap">
                    <th>id</th>
                    <th>Nom de publicité</th>
                    <th>Visbilité</th>
                    <th>Date de creation</th>
                    <th>Opérations</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i=0?>
                    @foreach ($ads as $ad)
                    <?php $i++?>
                  <tr >
                    <td class="table-row" data-href="{{route('ads.edit',$ad->id)}}">{{$i}}</td>
                    <td class="table-row" data-href="{{route('ads.edit',$ad->id)}}">{{$ad->name}}</td>
                    <td class="table-row" data-href="{{route('ads.edit',$ad->id)}}">
                      @if ($ad->is_Visible==true)
                        <a  class="text-success">Visible</a>
                      @else
                          <a  class="text-danger">Cachée</a>
                      @endif
                    </td>
                    <td>{{$ad->created_at}}</td>
                    <td>   
                      @can('effacer pub')
                      <button class="btn btn-danger btn-sm"
                      data-toggle="modal"
                      
                      data-ad_id="{{ $ad->id }}"
                    
                      data-target="#delete_file">
                      <i class="fas fa-trash"></i>&nbsp;Effacer</button></td>
                      @endcan
                  </tr>
                  <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Supprimer la publicité</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="{{ route('ads.destroy',$ad->id) }}" method="post">
                      {{ method_field('delete') }}
                      {{ csrf_field() }}
                      <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red">Voulez-vous vraiment supprimer cette publicité</h6>
                        </p>
            
                      
                        <input type="hidden" name="ad_id" id="ad_id" value="">
            
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
	
		var ad_id = button.data('ad_id')
		var modal = $(this)
	
		modal.find('.modal-body #ad_id').val(ad_id);
	})
</script>
@stop