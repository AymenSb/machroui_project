@extends('layouts.app', [
    'namePage' => 'Publicités',
    'class' => 'sidebar-mini',
    'activePage' => 'Ads',
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
            <h5 class="title">Ajouter une publicité</h5>
          </div>
          @can('modifier pub')
          <div class="card-body all-icons">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                  <div class="card-body">
                      <form action="{{ route('ads.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                          {{ csrf_field() }}
                          {{-- 1 --}}
  
                          <div class="row">
                              <div class="col">
                                  <label for="inputName" class="control-label">Nom de la publicité </label>
                                  <input type="text" class="form-control" id="name" name="name"
                                      title="Veuillez saisir le nom de la publicité" required>
                              </div>
  
                             
                   
                              <div class="col">
                                <label>Visibilité</label>
                                <select class="form-control" required id="is_Visible" name="is_Visible">
                                  <option>Visible</option>
                                  <option selected>Cachée</option>
                                </select>
                            </div>


  
                          </div>
                          <span style=" margin-left: 20px;"></span>


                          {{-- 2 --}}
                        
                        <span style=" margin-left: 20px;"></span>

                          {{-- 3 --}}
                        
                          <hr>

                        <h5 class="card-title">Ajouter une image</h5>

                        <div class="col-sm-12 col-md-12">
                            <input required type="file" name="image" multiple id="image" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                                data-height="70"  />
                        </div><br>

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
@stop