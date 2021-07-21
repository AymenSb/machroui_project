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
                           {{-- VALIDATIONS HERE --}} 
                           @if (session()->has('edit'))
                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                             <strong>{{ session()->get('edit') }}</strong>
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                             </button>
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
            <h5 class="title">Ajouter une formation</h5>
          </div>
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                @can('modifier formation')
                  <div class="card-body">
                    <form action='{{ route('formations.update',$formation) }}' method="post">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                          {{-- 1 --}}
  
                          <div class="row">
                              <div class="col">
                                  <label for="inputName" class="control-label">Nom de la formation </label>
                                  <input type="text" class="form-control" id="name" name="name" value="{{$formation->name}}"
                                      title="Veuillez saisir le nom de la formation" required>
                              </div>
  
                              <div class="col">
                                  <label>Date de début</label>
                                  <input class="form-control fc-datepicker" id="begin_date"name="begin_date" placeholder="DD-MM-YYYY"
                                      type="text" value="{{$formation->begin_date}}" required>
                              </div>
  
                              <div class="col">
                                <label for="inputName" class="control-label">places</label>
                                <input  style="place-holder:none;"type="number" class="form-control" id="inputPlaces" name="places"
                                    title="Veuillez saisir le nombre limites des places" value="{{$formation->places}}" required>
                            </div>

                            <div class="col">
                              <label for="inputName" class="control-label">Nom du formateur</label>
                              <input type="text" class="form-control" value="{{$formation->trainer}}" id="trainer" name="trainer"
                                  title="Veuillez saisir le nom du formateur">
                          </div>
  
                          </div>
                          <span style=" margin-left: 20px;"></span>


                          {{-- 2 --}}
                         <div class="row">
                            <div class="col">
                              <label for="inputName" class="control-label">Lieux de la formation</label>
                              <textarea type="text" class="form-control"  id="locale" name="locale"
                                  title="Veuillez saisir la Description"> {{$formation->locale}}</textarea>
                          </div>

                          
                            <div class="col">
                              <label for="inputName" class="control-label">Description</label>
                              <textarea type="text" class="form-control" id="description" name="description"
                                  title="Veuillez saisir la Description">{{$formation->description}}</textarea>
                          </div>
                          

                          <div class="col">
                            <label for="inputName" class="control-label">Plan de la formation</label>
                            <textarea type="text" class="form-control" id="plan" name="plan"
                                title="Veuillez saisir la Description">{{$formation->plan}}</textarea>
                          </div>
                         </div>
                            <span style=" margin-left: 20px;"></span>

                        {{-- 3 --}}
                        <div class="row">

                            <div class="col-2">
                          <label for="inputName" class="control-label">Prix de la formation </label>
                          <input type="text" class="form-control" id="price" name="price" value="{{$formation->price}}"
                              title="Veuillez saisir le nom de la formation" required>
                         </div>
                      
                            <div class="col-5">
                            <label for="inputName" class="control-label">Lien facebook</label>
                            <input type="text" class="form-control" id="link" name="link" value="{{$formation->link}}"
                            title="Veuillez saisir le nom de la formation" required>
                            </div>
                      

                            </div>
                         <span style=" margin-left: 20px;"></span>

                         <br><br>
                         <div class="row">
                          <p class="text-danger">	&nbsp;En sélectionnant une(des) catégorie(s), les catégories existantes de votre produit seront remplacées par celles que vous avez sélectionnées.</p>
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
                               <option value="" selected disabled>Choisissez une sous-catégorie</option>
                             </select>
                           </div>
                         </div>
                          {{-- 4--}}
                          <hr>
                          <div class="d-flex justify-content-center">
                              <input type="hidden" name="id" id="id" value="{{$formation->id}}" class="form-group">
                              <button type="submit" class="btn btn-primary" style="background-color:#FF3636">Mettre à jour</button>
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
                      $('select[name="subcategory[]"]').empty();
                      $.each(data, function(key, value) {
                          $('select[name="subcategory[]"]').append('<option value="' +
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