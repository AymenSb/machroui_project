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

                          {{-- 4--}}
                        
                          <hr>

                            <p class="text-danger">* La format de l'image est .jpg, .png</p>
                            <h5 class="card-title">Image</h5>
                            <input type="hidden" name="id" id="id" value="{{$formation->id}}">
                            <div class="col-sm-12 col-md-12">
                                <input type="file" name="image" id="image" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                                data-height="70"  />
                            </div><br>


                          {{-- 4 --}}
  
                         
  
                          {{-- 5 --}}
                        
  
  

                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary" style="background-color:#FF3636">Mettre à jour</button>
                          </div>
  
                            
                      </form>
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
@stop