@extends('layouts.app', [
'namePage' => 'Machines/details',
'class' => 'sidebar-mini',
'activePage' => 'Machines',
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
                        <h3 class="title">Machine/ Details</h3>
                        <a href= "{{route('editmachine',$machine->id)}}"class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Éditer</a>  
                    </div>
                    <div class="card-body all-icons">
                        {{-- place content here --}}

                        <!-- Tab links -->
                        <div class="tab">
                            <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'London')">Information géneral</button>
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Détails</button>
                            <button class="tablinks" onclick="openCity(event, 'char')">Charactéristique</button>
                            <button class="tablinks" onclick="openCity(event, 'mark')">Détails de la marque</button>
                            <button class="tablinks" onclick="openCity(event, 'images')">Images</button>
                        </div>
                        <!-- Tab content -->
                        <div id="London" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Nom de la machine")}}</label>
                                        <span type="text" name="name" class="form-control" >{{$machine->name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 pr-1">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("Etat de la machine")}}</label>
                                    <span type="text" name="state" id="state" class="form-control">{{$machine->state}}<span>
                                  </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                  <div class="form-group">
                                      <label>{{__("Prix")}}</label>
                                      <span type="text" name="price" class="form-control" >{{$machine->price}}</span>
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div id="Paris" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{__("detail de la machine")}}</label>
                                    <textarea readonly type="text" name="details" class="form-control" >{{$machine->details}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="char" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{__("Characteristiques de la machine")}}</label>
                                    <textarea readonly type="text" name="characteristics" class="form-control" >{{$machine->characteristics}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="mark" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{__("detail de la marque")}}</label>
                                    <textarea readonly type="text" name="mark" class="form-control" >{{$machine->markDetails}}</textarea>
                                </div>
                            </div>
                        </div>

                        
                        <div id="images" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{__("Images")}}</label>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr style=" white-space: nowrap">
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php $i=0?>
                                          @foreach ($images as $item)
                                          <?php $i++?>
                                        <tr class="table-row" data-href="machines/{{$machine->id}}">
                                          <td>{{$i}}</td>
                                          <td>{{$item->file_name}}</td>
                                          <td>
                                            <a class="btn btn-outline-success btn-sm" target="_blank"
                                            href= "{{ url('viewfile_machines') }}/{{ $machine->name }}/{{ $item->file_name }}"
                                            role="button"><i class="fas fa-eye"></i>&nbsp;
                                            Voir l'image</a></td>
                                            <td>
                                        <a class="btn btn-outline-info btn-sm"
                                            href= "{{ url('download_machines') }}/{{ $machine->name }}/{{ $item->file_name }}"
                                            role="button"><i
                                                class="fas fa-download"></i>&nbsp;
                                            Télécharger</a>
                                          </td>
                                         <td>
                                            <button class="btn btn-outline-danger btn-sm"
                                            data-toggle="modal"
                                            data-file_name="{{ $item->file_name }}"
                                            data-machine_id="{{ $item->machine_id }}"
                                            data-file_id="{{ $item->id }}"
                                            data-target="#delete_file">
                                            <i class="fas fa-trash"></i>&nbsp;Effacer</button>
                                         </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                      </table>
                                      <div class="card-body">
                                        <p class="text-danger">Image de type .jpg, .png </p>
                                        <h5 class="card-title">Ajouter images</h5>
                                        <form method="post" action="{{ route('addimage_machine.store') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="file_name"
                                                    name="file_name[]" required multiple>
                                                <input type="hidden" id="machine_name" name="machine_name"
                                                    value="{{ $machine->name }}">
                                                <input type="hidden" id="machine_id" name="machine_id"
                                                    value="{{ $machine->id }}">
                                                <label class="custom-file-label"  for="file_name">Select images
                                                    </label>
                                            </div><br><br>
                                            <button type="submit" class="btn btn-primary btn-sm "
                                                name="uploadedFile">Ajouter</button>
                                        </form>
                                    </div>
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
						 <form action="{{ route('deletefile_machine') }}" method="post">
							 {{ csrf_field() }}
							 <div class="modal-body">
								 <p class="text-center">
								 <h6 style="color:red">Voulez-vous vraiment supprimer cette image</h6>
								 </p>
		 
								 <input type="hidden" name="file_id" id="file_id" value="">
								 <input type="hidden" name="file_name" id="file_name" value="">
								 <input type="hidden" name="machine_id" id="machine_id" value="">
		 
							 </div>
							 <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Confirmer</button>
								 <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
								 
							 </div>
						 </form>
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
		var trainer = button.data('trainer')
		var places = button.data('places')
		var id = button.data('id')
		var begin_date = button.data('begin_date')
		var end_date = button.data('end_date')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #begin_date').val(begin_date);
		modal.find('.modal-body #end_date').val(end_date);
		modal.find('.modal-body #description').val(description);
		modal.find('.modal-body #name').val(name);
		modal.find('.modal-body #trainer').val(trainer);
		modal.find('.modal-body #places').val(places);
        
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
		var machine_id = button.data('machine_id')
		var modal = $(this)
		modal.find('.modal-body #file_id').val(file_id);
		modal.find('.modal-body #file_name').val(file_name);
		modal.find('.modal-body #machine_id').val(machine_id);
	})
</script>
@endsection
