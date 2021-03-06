@extends('layouts.app', [
    'namePage' => 'Formations',
    'class' => 'sidebar-mini',
    'activePage' => 'icons',
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
                      
            <h5 class="title">Ajouter une formation</h5>
          </div>
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                @can('crée formation')
                  <div class="card-body">
                      <form action="{{ route('formations.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                          {{ csrf_field() }}
                          {{-- 1 --}}
  
                          <div class="row">
                              <div class="col">
                                  <label for="inputName" class="control-label">Nom de la formation </label>
                                  <input type="text" class="form-control" id="name" name="name"
                                      title="Veuillez saisir le nom de la formation" required>
                              </div>
  
                              <div class="col">
                                  <label>Date de début</label>
                                  <input class="form-control fc-datepicker" id="begin_date"name="begin_date" placeholder="DD-MM-YYYY"
                                      type="text" value="{{ date('Y-m-d') }}" required>
                              </div>
  
                              <div class="col">
                                <label for="inputName" class="control-label">places</label>
                                <input  style="place-holder:none;"type="number" class="form-control" id="inputPlaces" name="places"
                                    title="Veuillez saisir le nombre limites des places" required>
                            </div>

                            <div class="col">
                              <label for="inputName" class="control-label">Nom du formateur</label>
                              <input type="text" class="form-control" id="trainer" name="trainer"
                                  title="Veuillez saisir le nom du formateur">
                          </div>
  
                          </div>
                          <span style=" margin-left: 20px;"></span>


                          {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                              <label for="inputName" class="control-label">Lieux de la formation</label>
                              <textarea type="text" class="form-control" id="locale" name="locale"
                                  title="Veuillez saisir la Description"></textarea>
                          </div>

                          
                            <div class="col">
                              <label for="inputName" class="control-label">Description</label>
                              <textarea type="text" class="form-control" id="description" name="description"
                                  title="Veuillez saisir la Description"></textarea>
                          </div>
                          

                          <div class="col">
                            <label for="inputName" class="control-label">Plan de la formation</label>
                            <textarea type="text" class="form-control" id="plan" name="plan"
                                title="Veuillez saisir la Description"></textarea>
                          </div>
                        </div>
                        <span style=" margin-left: 20px;"></span>

                       {{-- 3 --}}
                       <div class="row">
                        <div class="col-2">
                          <label for="inputName" class="control-label">Prix de la formation </label>
                          <input type="number" class="form-control" id="price" name="price" 
                              title="Veuillez saisir le nom de la formation" required>
                      </div>
                      
                      <div class="col-5">
                        <label for="inputName" class="control-label">Lien facebook</label>
                        <input type="text" class="form-control" id="link" name="link"
                            title="Veuillez saisir le nom de la formation" >
                    </div>
                      

                    </div>
                        <span style=" margin-left: 20px;"></span>

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
                            <select  multiple id="subcategory" name="subcategory[]" class="form-control">
                              <option value="" selected disabled>Choisissez une ou sous-catégorie(s)</option>
                            </select>
                          </div>
                        </div>

                          {{-- 4--}}
                        
                          <hr>

                        <p class="text-danger">* La photo est jpeg, .jpg, .png</p>
                        <h5 class="card-title">Ajouter l'image ici</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="image" id="image" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                               required data-height="70"  />
                        </div><br>


                          {{-- 4 --}}
  
                         
  
                          {{-- 5 --}}
                        
  
  

                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary" style="background-color:#FF3636">Save data</button>
                          </div>
  
  
                      </form>
                  </div>
                  @endcan
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