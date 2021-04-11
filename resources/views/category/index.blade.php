@extends('layouts.app', [
    'namePage' => 'Icons',
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
            <h5 class="title">Toutes les catégories</h5>
            <h3 class="card-title">
            <a href="#modaldemo9"
              data-effect="effect-fall" data-toggle="modal"
              class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Ajouter une categorie
            </a>  
            <a href="#modaldemo10"
              data-effect="effect-fall" data-toggle="modal"
              class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Ajouter une sous categorie
            </a>  
  </h3>
          </div>
          <div class="card-body all-icons">
            <div class="card-body">
              {{-- <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr style=" white-space: nowrap">
                  <th>id</th>
                  <th>Nom de la catégprie</th>
                  <th>Opérations</th>
                  
                </tr>
                </thead>
                <tbody>
                  <?php $i=0?>
                  @foreach ($categories as $item)
                      
                  <?php $i++?>
                <tr class="table-row" data-href="#">
                  <td>{{$i}}</td>
                  <td>{{$item->name}}</td>
                  <td>
                    <a href="">modifer</a>  
                    <a href="">supprimer</a>  
                  </td>
                  @endforeach

                </tr>
               
                </tbody>
                <tfoot>
              
                </tfoot>
              </table> --}}
              @foreach ($categories as $item)
                  <li>
                    {{$item->name}}
                    <ul>@foreach ($item->file as $x)
                        <li>{{$x->name}}</li>
                    @endforeach</ul>
                  </li>
              @endforeach
            </div>
            {{-- categories modal --}}
            <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
     <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajouter une catégorie</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action='{{ route('category.store') }}' method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                 <div class="form-group">
                    <label for="title">Nom de la catégorie</label>
                    <input type="text" required class="form-control" name="name" id="name" autocomplete="off" >
                  </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="background-color: #FF3636">Confirmer</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </form>
    </div>
</div>
            
          </div>
          <div>
            {{-- subcategory moda --}}
          <div class="modal fade" id="modaldemo10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
           <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ajouter une catégorie</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action='{{ route('subcategory.store') }}' method="post">
                  {{ csrf_field() }}
                  <div class="modal-body">
                      <div class="form-group">
                          <label>Catégorie</label>
                          <select class="form-control" required id="category_id" name="category_id">
                            <option disabled selected value style="display:none">sélectionner une catégorie</option>
                            @foreach ($categories as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                          </select>
                      </div>
      
                       <div class="form-group">
                          <label for="title">Nom de la sous-catégorie</label>
                          <input type="text" required class="form-control" name="name" id="name" autocomplete="off" >
                        </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" style="background-color: #FF3636">Confirmer</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                  </div>
              </form>
          </div>
      </div>
          </div>
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