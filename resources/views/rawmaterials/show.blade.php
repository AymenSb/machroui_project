@extends('layouts.app', [
'namePage' => 'Matiéres premiéres',
'class' => 'sidebar-mini',
'activePage' => 'Matiéres premiéres',
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
                        <h5 class="title">Matières premières/ Details</h5>
                        <a href="#modaldemo9"
                        data-price="{{$material->price}}"
                        data-description="{{$material->description}}"
                        data-name="{{$material->name}}"
                        data-id="{{$material->id}}" 
                        data-brand="{{$material->brand}}" 
                        data-effect="effect-fall" data-toggle="modal"
                        class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Éditer</a>  
                    </div>
                    <div class="card-body all-icons">
                        {{-- place content here --}}

                        <!-- Tab links -->
                        <div class="tab">
                            <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'London')">Détails</button>
                            <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'description')">Description</button>
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Image</button>
                        </div>
                        <!-- Tab content -->
                        <div id="London" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Nom de la matiére premiére")}}</label>
                                        <span type="text" name="name" class="form-control" >{{$material->name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-2 pr-1">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">{{__("Prix")}}</label>
                                    <span type="text" name="trainer" class="form-control">{{$material->price}}<span>
                                  </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                  <div class="form-group">
                                      <label>{{__("Marque")}}</label>
                                      <span type="text" name="name" class="form-control" >{{$material->brand}}</span>
                                  </div>
                              </div>
                            </div>
                        </div>

                        <div id="description" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                               
                                <div class="col-md-5 pr-3">
                                  <div class="form-group">
                                    <textarea  disabled type="text" name="trainer" class="form-control">{{$material->description}}</textarea>
                                  </div>
                                </div>
                            
                            </div>
                        </div>

                        <div id="Paris" class="tabcontent">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                              
                                </thead>
                                <tbody>
                                   @foreach ($image as $item)
                                      <td>{{$item->file_name}}</td>
                                      <td>
                                        <a class="btn btn-outline-success btn-sm" target="_blank"
                                        href= ""
                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                        Show</a></td>
                                        <td>
                                    <a class="btn btn-outline-info btn-sm"
                                        href= ""
                                        role="button"><i
                                            class="fas fa-download"></i>&nbsp;
                                        download</a>
                                      </td>
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
            <form action='{{ route('rawmaterials.update',$material->id) }}' method="post">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                <div class="modal-body">
                     <div class="form-group">
                        <label for="title">Nom</label>
                        <input type="text" class="form-control" name="name" id="name" autocomplete="off" >
                      </div>

                      <div class="form-group">
                        <label for="title">Prix</label>
                        <input type="number" class="form-control" name="price" id="price" autocomplete="off" >
                      </div>
                      <div class="form-group">
                        <label for="title">Marque</label>
                        <input type="text" class="form-control" name="brand" id="brand" autocomplete="off" >
                      </div>

                  <div class="form-group">
                    <label for="title">Description</label>
                    <textarea type="text" class="form-control" name="description" id="description" autocomplete="off" ></textarea>
                  </div>
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
		var brand = button.data('brand')
		var price = button.data('price')
		var id = button.data('id')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #name').val(name);
		modal.find('.modal-body #brand').val(brand);
		modal.find('.modal-body #price').val(price);
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #description').val(description);
	
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
