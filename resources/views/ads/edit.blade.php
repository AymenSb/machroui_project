@extends('layouts.app', [
'namePage' => 'Publicités',
'class' => 'sidebar-mini',
'activePage' => 'Ads',
])
@section('css')
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

    </style>


    <style>
        .tabcontent {
            animation: fadeEffect 0.5s;
            /* Fading effect takes 0.5 second */
        }

        /* Go from zero to full opacity */
        @keyframes fadeEffect {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

    </style>

<link rel="stylesheet" href="../../plugins/jquery-ui/jquery-ui.min.css">
<style>
  input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
@endsection

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
                          
                          @if (session()->has('file'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('file') }}</strong>
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
                          {{-- VALIDATION --}}
                        <h5 class="title">Publicite/ Editer</h5>
                        @can('modifier pub')
                        <a href="#modal1"
                        data-name="{{$ad->name}}"
                        data-id="{{$ad->id}}" 
                        data-is_Visible="{{$ad->is_Visible}}" 
                        data-effect="effect-fall" data-toggle="modal"
                        class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Éditer</a>  
                          @endcan    
                    </div>
                    <div class="card-body all-icons">
                        {{-- place content here --}}

                        <!-- Tab links -->
                        @can('gestion des pubs')
                        <div class="tab">
                            <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'London')">Détails</button>
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Image</button>
                        </div>
                        @endcan
                        <!-- Tab content -->
                        <div id="London" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Nom de la publicité")}}</label>
                                        <span type="text" name="name" class="form-control" >{{$ad->name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-2 pr-1">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("Visibilié")}}</label>
                                    <span type="text" name="is_Visible" class="form-control">
                                        @if ($ad->is_Visible==true)
                                            Visible
                                        @else
                                            Cachée
                                        @endif    
                                    <span>
                                  </div>
                                </div>
                                <div class="col-md-2 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Date de création")}}</label>
                                        <span type="date" name="date" class="form-control" >{{$ad->created_at}}</span>
                                    </div>
                                </div>
                                
                            </div>
                            {{-- 2 --}}                          
                        </div>
                        <div id="Paris" class="tabcontent">
                            <div class="form-group">
                                <label>{{__("Images")}}</label>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr style=" white-space: nowrap">
                                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i=0?>
                                    
                                      <?php $i++?>
                                    <tr>
                                      <td>{{$i}}</td>
                                      <td>{{$ad->file_name}}</td>
                                      <td>
                                        <a class="btn btn-outline-success btn-sm" target="_blank"
                                        href= "{{route('viewfile_ad',[$ad->id,$ad->file_name])}}"
                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                        Voir l'image</a></td>
                                        <td>
                                    <a class="btn btn-outline-info btn-sm"
                                        href= "{{route('downloadAd',[$ad->id,$ad->file_name])}}"
                                        role="button"><i
                                            class="fas fa-download"></i>&nbsp;
                                        Télécharger</a>
                                      </td>
                                    </tr>
                                    
                                    </tbody>
                                  </table>
                                  <div class="card-body">
                                   @can('modifier pub')
                                    <h5 class="card-title">Changer l'images</h5>
                                    <form method="post" action="{{ route('updatePIC',$ad->file_name) }}"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file_name"
                                                name="file_name" required >
                                            <input type="hidden" id="id" name="id"
                                                value="{{ $ad->id }}">
                                          
                                            <label class="custom-file-label"  for="file_name">Sélectionner une image
                                                </label>
                                        </div><br><br>
                                        <button type="submit" class="btn btn-primary btn-sm "
                                            name="uploadedFile">Validée</button>
                                    </form>
                                   @endcan 
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
         <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action='{{ route('ads.update',$ad->id) }}' method="post">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                <div class="modal-body">
                     <div class="form-group">
                        <label for="title">Nom</label>
                        <input type="text" class="form-control" name="name" id="name" autocomplete="off" >
                      </div>

                      <div class="form-group">
                        <label for="title">Visibilié</label>
                        <select class="form-control" required id="is_Visible" name="is_Visible">
                            <option>Visible</option>
                            <option selected>Cachée</option>
                          </select>                      </div>
                    
                
                  <input hidden name="id" id="id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="background-color: #FF3636">Confirmer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

    </div>
    
@endsection

@section('js')
    <script>
        function openCity(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        //default page
        document.getElementById("defaultOpen").click();

    </script>


<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../../plugins/jquery-ui/jquery-ui.js"></script>

<script>
 var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
</script>

<script>
	$('#modal1').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var name = button.data('name')
		var id = button.data('id')
		var is_Visible = button.data('is_Visible')
		var modal = $(this)
		modal.find('.modal-body #name').val(name);
		modal.find('.modal-body #id').val(id);
	})
</script>
@endsection
