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
                        <h5 class="title">Machine/ Details</h5>
                        <a href="#modaldemo9"
                        {{-- data-places="{{$formation->places}}"
                        data-trainer="{{$formation->trainer}}"
                        data-name="{{$formation->name}}"
                        data-begin_date="{{$formation->begin_date}}"
                        data-end_date="{{$formation->end_date}}" 
                        data-description="{{$formation->description}}"
                        data-id="{{$formation->id}}" --}}
                        data-effect="effect-fall" data-toggle="modal"
                        class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Éditer</a>  
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
                                    <textarea disabled type="text" name="details" class="form-control" >{{$machine->details}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="char" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{__("Characteristiques de la machine")}}</label>
                                    <textarea disabled type="text" name="characteristics" class="form-control" >{{$machine->characteristics}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="mark" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{__("detail de la marque")}}</label>
                                    <textarea disabled type="text" name="mark" class="form-control" >{{$machine->markDetails}}</textarea>
                                </div>
                            </div>
                        </div>

                        
                        <div id="images" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{__("Images")}}</label>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        
                                          
                                          
                                          
                                        </thead>
                                        <tbody>
                                            @foreach ((array)$files as $item)
                                                  @foreach ((array)$item as $x)
                                                      <span>{{$x}}</span>
                                                  @endforeach
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                         
                                        </tfoot>
                                      </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
         <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier la formation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action='{{ route('formations.update',$formation->id) }}' method="post">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                <div class="modal-body">
                     <div class="form-group">
                        <label for="title">Nom de la formation</label>
                        <input type="text" class="form-control" name="name" id="name" autocomplete="off" >
                      </div>

                      <div class="form-group">
                        <label for="title">Nom du formateur</label>
                        <input type="text" class="form-control" name="trainer" id="trainer" autocomplete="off" >
                      </div>
                      <div class="form-group">
                        <label for="title">Places</label>
                        <input type="number" class="form-control" name="places" id="places" autocomplete="off" >
                      </div>
                        <div class="form-group">
                        <label for="title">Date de début</label>

                        <input type="hidden" class="form-control" name="id" id="id" value="">
                        <input class="form-control fc-datepicker" id="begin_date"name="begin_date" placeholder="YYYY-MM-DD"
                                      type="text" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                      <label for="title">Date de fin</label>
                      <input class="form-control fc-datepicker" id="end_date"name="end_date" placeholder="YYYY-MM-DD"
                                      type="text" value="{{ date('Y-m-d') }}" required>
                    </div>
                  <div class="form-group">
                    <label for="title">Description</label>
                    <textarea type="text" class="form-control" name="description" id="description" autocomplete="off" ></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="background-color: #FF3636">Confirmer</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </form>
             </div>
                    </div>
        </div> --}}
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
@endsection
