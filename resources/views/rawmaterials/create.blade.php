@extends('layouts.app', [
    'namePage' => 'Matiéres premiéres',
    'class' => 'sidebar-mini',
    'activePage' => 'Matiéres premiéres',
])
@section('css')
<link rel="stylesheet" href="../../plugins/jquery-ui/jquery-ui.min.css">
<style>
  input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
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
            <h5 class="title">Ajouter une matiére premiére</h5>
          </div>
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                  <div class="card-body">
                    @can('crée matière première')

                      <form action="{{ route('rawmaterials.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                          {{ csrf_field() }}
                          {{-- 1 --}}
  
                          <div class="row">
                              <div class="col">
                                  <label for="inputName" class="control-label">Nom de la matiére premiére </label>
                                  <input type="text" class="form-control" id="name" name="name"
                                      title="Veuillez saisir le nom de la formation" required>
                              </div>
  
                             
                              <div class="col">
                                <label for="inputName" class="control-label">Nom de la marque </label>
                                <input type="text" class="form-control" id="brand" name="brand"
                                    title="Veuillez saisir le nom de la formation" required>
                            </div>

                              <div class="col">
                                <label for="inputName" class="control-label">Prix</label>
                                <input type="text" class="form-control" id="price" name="price"
                                    title="Veuillez saisir le nom de la formation" required>
                              </div>

  
                          </div>
                          <span style=" margin-left: 20px;"></span>


                          {{-- 2 --}}
                          <div class="row">
                            <div class="col" >
                                <label for="inputName" class="control-label">Description</label>
                                <textarea  style="width: 500px" style="place-holder:none;" class="form-control" id="description" name="description"
                                    title="Veuillez saisir le nombre limites des places" ></textarea>
                            </div>


                         
                        </div>
                        <span style=" margin-left: 20px;"></span>

                          {{-- 3 --}}
                          <br><br>
                          <div class="row">
                            <div class="col-3">
                              <label for="inputName" class="contro-label">Selectionnez une categorie</label>
                              <select  name="category" class="form-control SlectBox" onclick="console.log($(this).val())"
                              onchange="console.log('change is firing')">
                              <!--placeholder-->
                              <option value="" selected disabled>Choisissez une catégorie</option>
                              @foreach ($categories as $category)
                                  <option value="{{ $category->id }}"> {{ $category->name }}</option>
                              @endforeach
                              </select>
                            </div>
                          
                            <div class="colo-3">
                              <label for="inputName" class="control-label">Sous-Categorie</label>
                              <select multiple id="subcategory" name="subcategory[]" class="form-control">
                                <option value="" selected disabled>Choisissez une ou des sous-catégorie(s)</option>
                              </select>
                            </div>
                          </div>
                        <br>
                          <hr>

                        <h5 class="card-title">Ajouter une image</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="image[]" multiple id="image" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                                data-height="70"  />
                        </div><br>

                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary" style="background-color:#FF3636">Save data</button>
                          </div>
                      </form>
                      @endcan
                  </div>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
    
@stop

@section('js')
<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../../plugins/jquery-ui/jquery-ui.js"></script>

<script>
 var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
</script>

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
                      $('select[id="subcategory"]').empty();
                      $.each(data, function(key, value) {
                          $('select[id="subcategory"]').append('<option value="' +
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
@stop