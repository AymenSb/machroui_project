@extends('layouts.app', [
    'namePage' => 'Services',
    'class' => 'sidebar-mini',
    'activePage' => 'Services',
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
                           @if (session()->has('ADD'))
                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                             <strong>{{ session()->get('ADD') }}</strong>
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
            <h5 class="title">Ajouter un service</h5>
          </div>
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                @can('crée service')
                  <div class="card-body">
                      <form action="{{ route('services.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                          {{ csrf_field() }}
                          {{-- 1 --}}
  
                          <div class="row">
                              <div class="col">
                                  <label for="inputName" class="control-label">Nom du service</label>
                                  <input type="text" class="form-control" id="name" name="name"
                                      title="Veuillez saisir le nom du service" required>
                              </div>
  
                             
                              <div class="col">
                                <label for="inputName" class="control-label">Type </label>
                                <input type="text" class="form-control" id="type" name="type"
                                    title="Veuillez saisir une le de service" required>


  
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
                        
                          <hr>

                        <h5 class="card-title">Ajouter une ou des images</h5>

                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="image[]" multiple id="image" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                                data-height="70"  />
                        </div><br>

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
@stop