@extends('layouts.app', [
'namePage' => 'Icons',
'class' => 'sidebar-mini',
'activePage' => 'icons',
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
                        <h5 class="title">Formations/ Details</h5>
                        <a href="{{route('formations.edit',$formation->id)}}"
                        class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Éditer</a>  
                    </div>
                    <div class="card-body all-icons">
                        {{-- place content here --}}

                        <!-- Tab links -->
                        @can('afficher formation')
                        <div class="tab">
                            <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'London')">Détails</button>
                            <button class="tablinks" onclick="openCity(event, 'desc')">Déscription</button>
                            <button class="tablinks" onclick="openCity(event, 'plan')">Plan</button>
                            <button class="tablinks" onclick="openCity(event, 'link')">Lien</button>
                            @can('modfier formation')
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Image</button>
                            @endcan
                        </div>
                        @endcan
                        <!-- Tab content -->
                        <div id="London" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Nom de la formation")}}</label>
                                        <span type="text" name="name" class="form-control" >{{$formation->name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 pr-1">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("Formateur")}}</label>
                                    <span type="text" name="trainer" class="form-control">{{$formation->trainer}}<span>
                                  </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                  <div class="form-group">
                                      <label>{{__("Nombre des places")}}</label>
                                      <span type="text" name="name" class="form-control" >{{$formation->places}}</span>
                                  </div>
                              </div>
                            </div>
                            {{-- 2 --}}
                        
                            <div class="row">
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Date de début")}}</label>
                                        <span class="form-control " name="begin_date">{{$formation->begin_date}}</span>
                                      </div>
                                </div>
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Prix")}}</label>
                                        <span class="form-control">{{$formation->price}} Dt</span>
                                      </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Lieux de la formation")}}</label>
                                        <span class="form-control" style="font-size: 16px">{{$formation->locale}}</span>
                                      </div>
                              </div>
                            </div>
                      
                          
                        </div>
                        <div id="desc" class="tabcontent">
                            <textarea disabled name="" id="" cols="60" rows="10">{{$formation->description}}</textarea>
                        </div>
                        <div id="plan" class="tabcontent">
                            <textarea disabled name="" id="" cols="60" rows="10">{{$formation->plan}}</textarea>
                        </div>
                        <div id="link" class="tabcontent">
                            <textarea disabled name="" id="" cols="80" rows="1">{{$formation->link}}</textarea>
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
                                      @foreach ($attachments as $item)
                                      <?php $i++?>
                                    <tr>
                                      <td>{{$i}}</td>
                                      <td>{{$item->file_name}}</td>
                                      <td>
                                        <a class="btn btn-outline-success btn-sm" target="_blank"
                                        href= "{{route('ViewFormation',[$formation->name,$item->file_name])}}"
                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                        Voir l'image</a></td>
                                        <td>
                                    <a class="btn btn-outline-info btn-sm"
                                        href= "{{route('downloadFormation',[$formation->name,$item->file_name])}}"
                                        role="button"><i
                                            class="fas fa-download"></i>&nbsp;
                                        Télécharger</a>
                                      </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                  </table>
                                  <div class="card-body">
                                   
                                    <h5 class="card-title">Changer l'images</h5>
                                    <form method="post" action="{{ route('updateimage_formation.update',$formation->file->id) }}"
                                        enctype="multipart/form-data">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file_name"
                                                name="file_name" required >
                                            <input type="hidden" id="formation_name" name="formation_name"
                                                value="{{ $formation->name }}">
                                            <input type="hidden" id="formation_id" name="formation_id"
                                                value="{{ $formation->id }}">
                                            <label class="custom-file-label"  for="file_name">Sélectionner une image
                                                </label>
                                        </div><br><br>
                                        <button type="submit" class="btn btn-primary btn-sm "
                                            name="uploadedFile">Validée</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
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
@endsection
