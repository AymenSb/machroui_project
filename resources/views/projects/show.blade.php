@extends('layouts.app', [
'namePage' => 'Detail Du projet',
'class' => 'sidebar-mini',
'activePage' => 'project',
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
                         @if (session()->has('delete'))
                         <div class="alert alert-warning alert-with-icon" data-notify="container">
                          <button type="button" aria-hidden="true" data-dismiss="alert" class="close">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                          </button>
                          <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                          <span data-notify="message">{{ session()->get('delete') }}</span>
                        </div>
                         @endif

                         @if (session()->has('created'))
                         <div class="alert alert-info alert-with-icon" data-notify="container">
                          <button type="button" aria-hidden="true" data-dismiss="alert" class="close">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                          </button>
                          <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                          <span data-notify="message">{{ session()->get('created') }}</span>
                        </div>
                         @endif
                         @if (session()->has('updated'))
                         <div class="alert alert-info alert-with-icon" data-notify="container">
                          <button type="button" aria-hidden="true" data-dismiss="alert" class="close">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                          </button>
                          <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                          <span data-notify="message">{{ session()->get('updated') }}</span>
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
                        <h5 class="title">Projet/ Details</h5>
                  
                    </div>
                    
                    <div class="card-body all-icons">
                        @can('modifier projet')
                        <a href="#modaldemo9"
                        data-type="{{$project->project_type}}"
                        data-informations="{{$project->informations}}"
                        data-name="{{$project->name}}"
                        data-id="{{$project->id}}" 
                        data-effect="effect-fall" data-toggle="modal"
                        class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Éditer</a> 
                        @endcan
                        {{-- place content here --}}

                        <!-- Tab links -->
                        @can('projet')
                        <div class="tab">
                            <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'London')">Détails</button>
                            <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'description')">Description</button>
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Image</button>
                            <button class="tablinks" onclick="openCity(event, 'cahier')">Cahier de charge</button>
                            
                        </div>
                        @endcan
                        <!-- Tab content -->
                        <div id="London" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Nom du projet")}}</label>
                                        <span type="text" name="name" class="form-control" >{{$project->name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-2 pr-1">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("Type")}}</label>
                                    <span type="text" name="type" class="form-control">{{$project->project_type}}<span>
                                  </div>
                                </div>
                               
                            </div>
                        </div>

                        <div id="description" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                               
                                <div class="col-md-5 pr-3">
                                  <div class="form-group">
                                    <textarea  disabled type="text" name="informations" class="form-control">{{$project->informations}}</textarea>
                                  </div>
                                </div>
                            
                            </div>
                        </div>

                        <div id="Paris" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{__("Images")}}</label>
                                   {{-- place table here --}}
                                   @if ($project->images)
                                   <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr style=" white-space: nowrap">
                                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i=0?>
                                      @foreach ($project->images as $image)
                                      <?php $i++?>
                                    <tr>
                                      <td>{{$i}}</td>
                                      <td>{{$image}}</td>
                                      <td>
                                        <a class="btn btn-outline-success btn-sm" target="_blank"
                                         href= "{{ url('viewfile_project') }}/{{ $project->name }}/{{ $image }}" 
                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                        Voir l'image</a></td>
                                        <td>
                                    <a class="btn btn-outline-info btn-sm"
                                        href= "{{ url('download_project') }}/{{ $project->name }}/{{ $image }}" 
                                        role="button"><i
                                            class="fas fa-download"></i>&nbsp;
                                        Télécharger</a>
                                      </td>
                                     <td>
                                         @can('modifier projet')
                                        <button class="btn btn-outline-danger btn-sm"
                                        data-toggle="modal"
                                        data-file_name="{{ $image }}"
                                        data-project_id="{{ $project->id }}"
                                        data-file_id="{{ $project->id }}"
                                        data-target="#delete_file">
                                        <i class="fas fa-trash"></i>&nbsp;Effacer</button>
                                        @endcan
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                   @endif
                                    
                                      @can('modifier projet')
                                      <div class="card-body">
                                        <p class="text-danger">Image de type .jpg, .png </p>
                                        <h5 class="card-title">Ajouter images</h5>
                                        <form method="post" action="{{ route('addimage_project.store') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file_name"
                                                    name="file_name[]" required multiple accept=".jpg, .png, image/jpeg, image/png">
                                                <input type="hidden" id="project_name" name="project_name"
                                                    value="{{ $project->name }}">
                                                <input type="hidden" id="project_id" name="project_id"
                                                    value="{{ $project->id }}">
                                                <label class="custom-file-label"  for="file_name">Select images
                                                    </label>
                                            </div><br><br>
                                            <button type="submit" class="btn btn-primary btn-sm "
                                                name="uploadedFile">Ajouter</button>
                                        </form>
                                    </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        {{-- PDF file --}}
                        <div id="cahier" class="tabcontent">
                            <div class="form-group">
                                <label>{{__("Images")}}</label>
                                @if ($project->pdf_file)
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr style=" white-space: nowrap">
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                      <td>{{$project->pdf_file}}</td>
                                      <td>
                                        <a class="btn btn-outline-success btn-sm" target="_blank"
                                        href= "{{route('viewPdfFile',[$project->name,$project->pdf_file])}}"
                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                        Voir</a></td>
                                        <td>
                                    <a class="btn btn-outline-info btn-sm"
                                        href= "{{route('downloadPdfFile',[$project->name,$project->pdf_file])}}"
                                        role="button"><i
                                            class="fas fa-download"></i>&nbsp;
                                        Télécharger</a>
                                      </td>
                                    </tr>
                                    </tbody>
                                </table>
                                @endif
                                  <div class="card-body">
                                    @can('modifier formation')
                                    <h5 class="card-title">Changer la cahier de charge</h5>
                                    <form method="post" action="{{ route('updatePDF.update',$project->id) }}"
                                        enctype="multipart/form-data">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <div class="custom-file">
                                            <input accept=".pdf" type="file" class="custom-file-input" id="file_name"
                                                name="file_name" required >
                                            <input type="hidden" id="project_name" name="project_name"
                                                value="{{ $project->name }}">
                                            <input type="hidden" id="project_id" name="project_id"
                                                value="{{ $project->id }}">
                                            <label class="custom-file-label"  for="file_name">Sélectionner un ficher
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

         <!-- delete image-->
				<div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				 aria-hidden="true">
				 <div class="modal-dialog" role="document">
					 <div class="modal-content">
						 <div class="modal-header">
							 <h5 class="modal-title" id="exampleModalLabel">Supprimer l'image</h5>
							 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								 <span aria-hidden="true">&times;</span>
							 </button>
						 </div>
						 <form action="{{ route('deletefile_project') }}" method="post">
							 {{ csrf_field() }}
							 <div class="modal-body">
								 <p class="text-center">
								 <h6 style="color:red">Voulez-vous vraiment supprimer cette image</h6>
								 </p>
		 
								 <input type="hidden" name="file_id" id="file_id" value="">
								 <input type="hidden" name="file_name" id="file_name" value="">
								 <input type="hidden" name="project_id" id="project_id" value="">
		 
							 </div>
							 <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Confirmer</button>
								 <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
								 
							 </div>
						 </form>
					 </div>
                    </div>
                </div>


        <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
         <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier la formation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action='{{ route('project.update',$project->id) }}' method="post">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                <div class="modal-body">
                     <div class="form-group">
                        <label for="title">Nom</label>
                        <input type="text" class="form-control" name="name" id="name" autocomplete="off" >
                      </div>

                      <div class="form-group">
                        <label for="title">Type</label>
                        <input type="text" class="form-control" name="type" id="type" autocomplete="off" >
                      </div>
                 
                  <div class="form-group">
                    <label for="title">Informations</label>
                    <textarea type="text" class="form-control" name="informations" id="informations" autocomplete="off" ></textarea>
                  </div>
                  <input hidden name="id" id="id" value="">
                  <div class="form-group">
                    <p class="text-danger">	&nbsp;En sélectionnant une(des) catégorie(s), les catégories existantes de votre produit seront remplacées par celles que vous avez sélectionnées.</p>

                    <label for="title">Selectionnez une categorie</label>
                    <select name="category" class="form-control SlectBox">
                        
                        <!--placeholder-->
                        <option value="" selected disabled>Choisissez une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"> {{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label for="title">Sous-Categorie</label>
                    <select multiple id="subcategory" name="subcategory[]" class="form-control">
                        <option value="" selected disabled>Choisissez une sous-catégorie</option>
                    </select>

                </div>
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

    <script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var name = button.data('name')
		var type = button.data('type')
		var informations = button.data('informations')
		var id = button.data('id')
		var modal = $(this)
		modal.find('.modal-body #name').val(name);
		modal.find('.modal-body #type').val(type);
		modal.find('.modal-body #informations').val(informations);
		modal.find('.modal-body #id').val(id);
	
	})
    </script>

<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../../plugins/jquery-ui/jquery-ui.js"></script>

<script>
 var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
</script>

<script>
	$('#delete_file').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var file_id = button.data('file_id')
		var file_name = button.data('file_name')
		var project_id = button.data('project_id')
		var modal = $(this)
		modal.find('.modal-body #file_id').val(file_id);
		modal.find('.modal-body #file_name').val(file_name);
		modal.find('.modal-body #project_id').val(project_id);
	})
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
@endsection
