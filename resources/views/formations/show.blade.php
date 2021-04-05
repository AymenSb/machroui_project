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
@endsection

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Formations/ Details</h5>
                        <a href="#modaldemo9"
                        data-places="{{$formation->places}}"
                        data-trainer="{{$formation->trainer}}"
                        data-name="{{$formation->name}}"
                        data-begin_date="{{$formation->begin_date}}"
                        data-end_date="{{$formation->end_date}}" 
                        data-description="{{$formation->description}}"
                        data-id="{{$formation->id}}"
                        data-effect="effect-fall" data-toggle="modal"
                           class="btn btn-primary btn-round" style="color: white;background-color:#FF3636;">Éditer</a>  
                    </div>
                    <div class="card-body all-icons">
                        {{-- place content here --}}

                        <!-- Tab links -->
                        <div class="tab">
                            <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'London')">Détails</button>
                            <button class="tablinks" onclick="openCity(event, 'Paris')">Image</button>
                        </div>

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
                                        <label>{{__("Date de fin")}}</label>
                                        <span class="form-control">{{$formation->end_date}}</span>
                                      </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label>{{__("Description")}}</label>
                                        <span class="form-control" style="font-size: 16px">{{$formation->description}}</span>
                                      </div>
                              </div>
                            </div>
                      
                          
                        </div>

                        <div id="Paris" class="tabcontent">
                            <h3>Paris</h3>
                            <p>Paris is the capital of France.</p>
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
@endsection
