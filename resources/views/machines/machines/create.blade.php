@extends('layouts.app', [
    'namePage' => 'Machines/ ajoute',
    'class' => 'sidebar-mini',
    'activePage' => 'Machines',
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
                          
            <h5 class="title">Ajouter une machine</h5>
          </div>
          @can('crée machine')
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                  <div class="card-body">
                      <form action="{{ route('machines.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                          {{ csrf_field() }}
                          {{-- 1 --}}
  
                          <div class="row">
                              <div class="col">
                                  <label for="inputName" class="control-label">Nom de la machine </label>
                                  <input type="text" class="form-control" id="name" name="name"
                                      title="Veuillez saisir le nom de la formation" required>
                              </div>
  
                              <div class="col">
                                    <label for="inputName" class="control-label">Prix</label>
                                    <input type="number" class="form-control" id="price" name="price"
                                    title="Veuillez saisir le nom de la formation" required>
                                </div>
  
                              <div class="col">
                                  <label>Etat de la machine</label>
                                  <select class="form-control" required id="state" name="state">
                                    <option disabled selected value style="display:none">sélectionner l'état de la machine</option>
                                    <option>Nouvelle machine</option>
                                    <option>Machine d'occasion</option>
                                  </select>
                              </div>
  
                          </div>
                          <span style=" margin-left: 20px;"></span>


                          {{-- 2 --}}
                          <div class="row">
                           

                            <div class="col-4">
                              <label for="inputName" class="control-label">Détails de la machine</label>
                             <textarea class="form-control" required id="details" name="details"></textarea>
                          </div>
                          
                          <div class="col-4">
                            <label for="inputName" class="control-label">Les caractéristiques</label>
                           <textarea class="form-control" required id="characteristics" name="characteristics"></textarea>
                        </div>
                        
                        <div class="col-4">
                          <label for="inputName" class="control-label">Détails de la marque</label>
                         <textarea class="form-control" required id="markDetails" name="markDetails"></textarea>
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
                            <select multiple id="subcategory" name="subcategory[]" class="form-control">
                              <option value="" selected disabled>Choisissez une ou des sous-catégorie(s)</option>
                            </select>
                          </div>
                        </div>
                        <span style=" margin-left: 20px;"></span>

                          {{-- 4 --}}
                        
                          <hr>

                        <p class="text-danger">* La format des images est jpeg, .jpg, .png</p>
                        <h5 class="card-title">Ajouter des images</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="image[]" id="images" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                                data-height="70"    multiple/>
                        </div><br>


                          {{-- 4 --}}
                          <span style=" margin-left: 20px;"></span>

                          {{-- 4 --}}
                        
                          <hr>

                        <p class="text-danger">* La format du video .mp4</p>
                        <h5 class="card-title">Ajouter une séquence vidéo</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="video" id="video" class="dropify" accept=".mp4"
                                data-height="70"    />
                        </div><br>
                         
  
                          {{-- 5 --}}
                        
  
  

                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary" style="background-color:#FF3636">Save data</button>
                          </div>
  
  
                      </form>
                  </div>
              </div>
            </div>
          </div>
          @endcan
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