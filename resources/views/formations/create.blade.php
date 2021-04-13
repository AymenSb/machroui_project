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
            <h5 class="title">Ajouter une matière première</h5>
          </div>
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
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
                                  <label>Date de fin</label>
                                  <input class="form-control fc-datepicker"  name="end_date" placeholder="DD-MM-YYYY"
                                      type="text" value="{{ date('Y-m-d') }}"  data-provide="datepicker" required>
                                      
                              </div>
  
                          </div>
                          <span style=" margin-left: 20px;"></span>


                          {{-- 2 --}}
                          <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">places</label>
                                <input  style="place-holder:none;"type="number" class="form-control" id="inputPlaces" name="places"
                                    title="Veuillez saisir le nombre limites des places" required>
                            </div>

                            <div class="col">
                              <label for="inputName" class="control-label">Description</label>
                              <input type="text" class="form-control" id="description" name="description"
                                  title="Veuillez saisir la Description">
                          </div>
                            <div class="col">
                              <label for="inputName" class="control-label">Nom du formateur</label>
                              <input type="text" class="form-control" id="trainer" name="trainer"
                                  title="Veuillez saisir le nom du formateur">
                          </div>

                         
                        </div>
                        <span style=" margin-left: 20px;"></span>

                          {{-- 3 --}}
                        
                          <hr>

                        <p class="text-danger">* La format de pièce jointe est jpeg, .jpg, .png</p>
                        <h5 class="card-title">Pièces jointes</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="image" id="image" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                                data-height="70" required />
                        </div><br>


                          {{-- 4 --}}
  
                         
  
                          {{-- 5 --}}
                        
  
  

                          <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary" style="background-color:#FF3636">Save data</button>
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