@extends('layouts.app', [
    'namePage' => 'Projet/ ajoute',
    'class' => 'sidebar-mini',
    'activePage' => 'project',
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
<style>

textarea::-webkit-scrollbar {
  width: 12px;
  background-color: #F5F5F5; }

textarea::-webkit-scrollbar-thumb {
  border-radius: 10px;
  -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
  background-color: #FF3636; }
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
                          
            <h5 class="title">Ajouter une projet</h5>
          </div>
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                @can('crée projet')
                  <div class="card-body">
                      <form action="{{ route('project.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                          {{ csrf_field() }}
                          {{-- 1 --}}
  
                          <div class="row">
                              <div class="col">
                                  <label for="inputName" class="control-label">Nom du projet </label>
                                  <input type="text" class="form-control" id="name" name="name"
                                      title="Veuillez saisir le nom de la formation" required>
                              </div>
  
                              <div class="col">
                                    <label for="inputName" class="control-label">Type du projet</label>
                                    <input type="text" class="form-control" id="type" name="type"
                                    title="Veuillez saisir le nom de la formation" required>
                                </div>
  
                         
  
                          </div>
                          <span style=" margin-left: 20px;"></span>


                          {{-- 2 --}}
                          <div class="row">
                           

                            <div class="col-4">
                              <label for="inputName" class="control-label">Informations du projet</label>
                             <textarea class="form-control" required id="informations" name="informations"></textarea>
                          </div>
                    

                         
                        </div>
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
                                    <select  id="subcategory" name="subcategory" class="form-control">
                                      <option value="" selected disabled>Choisissez une sous-catégorie</option>
                                    </select>
                                  </div>
                                </div>
                        <span style=" margin-left: 20px;"></span>

                          {{-- 4 --}}
                        
                          <hr>

                        <p class="text-danger">* La format de pièce jointe est jpeg, .jpg, .png</p>
                        <h5 class="card-title">Pièces jointes</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="image[]" multiple id="images" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                                data-height="70"    multiple/>
                        </div><br>


                          {{-- 4 --}}
  
                         
  
                          {{-- 5 --}}
                        
  
  

                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary" style="background-color:#FF3636">Save data</button>
                          </div>
  
  
                      </form>
                  </div>
              </div>
              @endcan
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
@stop