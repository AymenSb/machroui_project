@extends('layouts.app', [
    'namePage' => 'Categories',
    'class' => 'sidebar-mini',
    'activePage' => 'categories',
])
@section('css')
<style>
  ul,li{
  list-style-type: none;
}

</style>
@endsection

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
@can('categories')
      @can('crée categorie')
      <div class="col-md-6">
        <div class="card" style="height: 323px" >
          <div class="card-header">
            <h3>Nouvelle catégorie</h3>
          </div>

          <div class="card-body">
            <form action="{{ route('category.store') }}" method="POST" autocomplete="off">
              @csrf
              <div class="form-group">
                <input type="text" name="name"  class="form-control" value="" placeholder="Nom de catégorie" required="">
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endcan

      @can('crée categorie')
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3>nouvelle sous-catégorie</h3>
          </div>

          <div class="card-body">
            <form action="{{ route('subcategory.store') }}" method="POST">
              @csrf
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
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
                 &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                 @can('modifier categorie')
                 <a href="#modaldemo9"
              data-effect="effect-fall" data-toggle="modal"
              class="btn btn-secendary" style="color: white;background-color:#FF3636;">Gestion des sous-catégories
                @endcan    
            </a>  
              </div>
            </form>
          </div>
        </div>
      </div>
      @endcan

      

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Catégories</h5>
            
          </div>
          <div class="card-body all-icons">
            

            <li>
              @foreach ($categories as $category)
                  
              
              <a data-toggle="collapse" href="#{{$category->name}}">
                <p>
                  {{$category->name}}
                  <b class="caret"></b>
                </p>
              </a>
             
              <div class="collapse" id="{{$category->name}}">
                @foreach ($category->subcategory as $subcategory)
                <ul class="">
                  <li >
                    <a data-toggle="collapse" href="#{{$subcategory->slug}}">
                      <p> {{($subcategory->name)}}
                        <b class="caret"></b>
                      </p> 
                    </a>
                    <div class="collapse" id="{{$subcategory->slug}}">
                      <ul><b>Formations</b>
                        
                        @foreach ($subcategory->formations as $formation)
                            <ul><a href="formations/{{$formation->id}}">{{$formation->name}}</a></ul>
                        @endforeach
                      </ul>
                      
                      <ul><b>Machines</b>
                        @foreach ($subcategory->machines as $machine)
                            <ul><a href="machines/{{$machine->id}}">{{$machine->name}}</a></ul>
                        @endforeach
                      </ul>

                      <ul><b>Matières premières</b>
                        @foreach ($subcategory->materials as $material)
                            <ul><a href="rawmaterials/{{$material->id}}">{{$material->name}}</a></ul>
                        @endforeach
                      </ul>

                    </div>
                  </li>
                </ul>
                @endforeach
              </div>
              @endforeach
            </li>
          </div>
        </div>
        <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
         <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gestion des sous-categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action='{{ route('addToSub') }}' method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                  <label>Catégorie</label>
                  <select required name="category" class="form-control SlectBox" onclick="console.log($(this).val())"
                      onchange="console.log('change is firing')">
                      <!--placeholder-->
                      <option value="" selected disabled>Choisissez une catégorie</option>
                      @foreach ($categories as $category)
                          <option value="{{ $category->id }}"> {{ $category->name }}</option>
                      @endforeach
                  </select>
                  <br>
                  <label for="inputName" class="control-label">Sous-Categorie</label>
                  <select required id="subcategory" name="subcategory" class="form-control">
                  </select>
                      <br>    
                  <label>Formations</label>
                  <select  name="formation" class="form-control SlectBox">
                      <!--placeholder-->
                      <option value="" selected disabled>Choisissez une formation</option>
                      @foreach ($formations as $formation)
                          <option value="{{ $formation->id }}"> {{ $formation->name }}</option>
                      @endforeach
                  </select>
                  <br>
                  <label>Machines</label>
                  <select  name="machine" class="form-control SlectBox">
                    <!--placeholder-->
                    <option value="" selected disabled>Choisissez une machine</option>
                    @foreach ($machines as $machine)
                        <option value="{{ $machine->id }}"> {{ $machine->name }}</option>
                    @endforeach
                </select>

                <label>Matières premières</label>
                <select  name="material" class="form-control SlectBox">
                  <!--placeholder-->
                  <option value="" selected disabled>Choisissez une matière première</option>
                  @foreach ($materials as $material)
                      <option value="{{ $material->id }}"> {{ $material->name }}</option>
                  @endforeach
              </select>
                    
               
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
  @endcan
  </div>
</div>
@stop

@section('js')

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
        
<script>
  $(document).ready(function() {
      $('select[name="category"]').on('change', function() {
          var id = $(this).val();
          if (id) {
              $.ajax({
                  url: "{{ URL::to('getsubcategory') }}/" + id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                      $('select[name="subcategory"]').empty();
                      $.each(data, function(key, value) {
                          $('select[name="subcategory"]').append('<option value="' +
                              key + '">' + value + '</option>');
                      });
                  },
              });
          } else {
              console.log('AJAX load did not work');
          }
      });
  });
</script>

<script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var category_id = button.data('category_id')
		var subcategory_id = button.data('subcategory_id')
		var modal = $(this)
		modal.find('.modal-body #category_id').val(category_id);
		modal.find('.modal-body #subcategory_id').val(subcategory_id);
        
	})
    </script>

@endsection