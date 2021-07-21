@extends('layouts.app', [
    'namePage' => 'Machines/ modifier',
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
                           {{-- VALIDATIONS HERE --}} 
                           @if (session()->has('Add'))
                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                             <strong>{{ session()->get('Add') }}</strong>
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
            <h5 class="title">modifier la machine</h5>
          </div>
          @can('modifier machine')
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                  <div class="card-body">
                    <form action='{{ route('machines.update',$machine->id) }}' method="post">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}

                          {{-- 1 --}}
                           
                          <div class="row">
                              <div class="col">
                                  <label for="inputName" class="control-label">Nom de la machine </label>
                                  <input type="text" value="{{$machine->name}}" class="form-control" id="name" name="name"
                                      title="Veuillez saisir le nom de la formation" required>
                              </div>
  
                              <div class="col">
                                    <label for="inputName" class="control-label">Prix</label>
                                    <input type="number" value="{{$machine->price}}" class="form-control" id="price" name="price"
                                    title="Veuillez saisir le nom de la formation" required>
                                </div>


  
                              <div class="col">
                                  <label>Etat de la machine</label>
                                  <select class="form-control" required id="state" name="state">
                                    <option selected  style="display:none">{{$machine->state}}</option>
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
                             <textarea class="form-control"  required id="details" name="details">{{$machine->details}}</textarea>
                          </div>
                          
                          <div class="col-4">
                            <label for="inputName" class="control-label">Les caractéristiques</label>
                           <textarea class="form-control" required id="characteristics" name="characteristics">{{$machine->characteristics}}</textarea>
                        </div>
                        
                        <div class="col-4">
                          <label for="inputName" class="control-label">Détails de la marque</label>
                         <textarea class="form-control" required id="markDetails" name="markDetails">{{$machine->markDetails}}</textarea>
                      </div>
                      <input type="number" value="{{$machine->id}}"  style="visibility: hidden" id="id" name="id">
                      <input type="number" value="{{$machine->stateVal}}"  style="visibility:hidden" id="stateVal" name="stateVal">

                         
                        </div>
                        <span style=" margin-left: 20px;"></span>

                        <div class="row">
                        <p class="text-danger">	&nbsp;En sélectionnant une(des) catégorie(s), les catégories existantes de votre produit seront remplacées par celles que vous avez sélectionnées.</p>
                          <div class="col-3">
                            <label for="inputName" class="contro-label">Selectionnez une categorie</label>
                            <select  name="category" class="form-control SlectBox"
                            >
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
                        <br><br>

                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary" style="background-color:#FF3636">mettre à jour</button>
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