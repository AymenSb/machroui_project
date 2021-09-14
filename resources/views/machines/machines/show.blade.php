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
                        @can('modifier machine')
                            <a href="{{ route('machines.edit', $machine->id) }}" class="btn btn-primary btn-round"
                                style="color: white;background-color:#FF3636;">Éditer</a>
                        @endcan
                    </div>
                    <div class="card-body all-icons">
                        {{-- place content here --}}

                        <!-- Tab links -->
                        @can('machines')
                            <div class="tab">

                                <button class="tablinks" id='defaultOpen' onclick="openCity(event, 'London')">Information
                                    géneral</button>
                                <button class="tablinks" onclick="openCity(event, 'Paris')">Détails</button>
                                <button class="tablinks" onclick="openCity(event, 'char')">Charactéristique</button>
                                <button class="tablinks" onclick="openCity(event, 'mark')">Détails de la marque</button>
                                @can('modifier machine')
                                    <button class="tablinks" onclick="openCity(event, 'images')">Images</button>
                                @endcan
                                <button class="tablinks" onclick="openCity(event, 'video')">Vidéo</button>
                                <button class="tablinks" onclick="openCity(event, 'offers')">Les offres</button>
                            </div>
                        @endcan
                        <!-- Tab content -->
                        <div id="London" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label>{{ __('Nom de la machine') }}</label>
                                        <span type="text" name="name" class="form-control">{{ $machine->name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 pr-1">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('Etat de la machine') }}</label>
                                        <span type="text" name="state" id="state"
                                            class="form-control">{{ $machine->state }}<span>
                                    </div>
                                </div>
                                <div class="col-md-3 pr-1">
                                    <div class="form-group">
                                        <label>{{ __('Prix') }}</label>
                                        <span type="text" name="price" class="form-control">{{ $machine->price }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="Paris" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{ __('detail de la machine') }}</label>
                                    <textarea readonly type="text" name="details"
                                        class="form-control">{{ $machine->details }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="char" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{ __('Characteristiques de la machine') }}</label>
                                    <textarea readonly type="text" name="characteristics"
                                        class="form-control">{{ $machine->characteristics }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="mark" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    <label>{{ __('detail de la marque') }}</label>
                                    <textarea readonly type="text" name="mark"
                                        class="form-control">{{ $machine->markDetails }}</textarea>
                                </div>
                            </div>
                        </div>


                        <div id="images" class="tabcontent">
                            <div class="col-md pr-1">
                                <div class="form-group">
                                    @if ($machine->images)
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr style=" white-space: nowrap">
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($machine->images as $item)
                                                    <?php $i++; ?>
                                                    <tr class="table-row" data-href="machines/{{ $machine->id }}">
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $item }}</td>
                                                        <td>
                                                            <a class="btn btn-outline-success btn-sm" target="_blank"
                                                                href="{{ url('viewfile_machines') }}/{{ $machine->name }}/{{ $item }}"
                                                                role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                Voir l'image</a>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-outline-info btn-sm"
                                                                href="{{ url('download_machines') }}/{{ $machine->name }}/{{ $item }}"
                                                                role="button"><i class="fas fa-download"></i>&nbsp;
                                                                Télécharger</a>
                                                        </td>
                                                        <td>
                                                            @can('modifier machine')
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    data-toggle="modal" data-file_name="{{ $item }}"
                                                                    data-machine_id="{{ $machine->id }}"
                                                                    data-file_id="{{ $machine->id }}"
                                                                    data-target="#delete_file">
                                                                    <i class="fas fa-trash"></i>&nbsp;Effacer</button>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    @can('modifier machine')
                                        <div class="card-body">
                                            <p class="text-danger">Image de type .jpg, .png </p>
                                            <h5 class="card-title">Ajouter images</h5>
                                            <form method="post" action="{{ route('addimage_machine.store') }}"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file_name"
                                                        name="file_name[]" required multiple
                                                        accept=".jpg, .png, image/jpeg, image/png">
                                                    <input type="hidden" id="machine_name" name="machine_name"
                                                        value="{{ $machine->name }}">
                                                    <input type="hidden" id="machine_id" name="machine_id"
                                                        value="{{ $machine->id }}">
                                                    <label class="custom-file-label" for="file_name">Select images
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
                        <div id="video" class="tabcontent">
                            <div class="form-group">
                                @if ($machine->video_name && $machine->video_base64)
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr style=" white-space: nowrap">
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>

                                                <td>{{ $machine->video_name }}</td>
                                                <td>
                                                    <a class="btn btn-outline-success btn-sm" target="_blank"
                                                        href="{{ route('view_video', [$machine->name, $machine->video_name]) }}"
                                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                                        Voir la séquance vidéo</a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-outline-info btn-sm"
                                                        href="{{ route('download_video', [$machine->name, $machine->video_name]) }}"
                                                        role="button"><i class="fas fa-download"></i>&nbsp;
                                                        Télécharger</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">Changer la séquance vidéo</h5>
                                    <form method="post" action="{{ route('change_video', $machine->id) }}"
                                        enctype="multipart/form-data">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="video" name="video" required
                                                accept=".mp4">
                                            <input type="hidden" id="machine_name" name="machine_name"
                                                value="{{ $machine->name }}">
                                            <input type="hidden" id="machine_id" name="machine_id"
                                                value="{{ $machine->id }}">
                                            <label class="custom-file-label" for="video">Sélectionner un vidéo
                                            </label>
                                        </div><br><br>
                                        <button type="submit" class="btn btn-primary btn-sm "
                                            name="uploadedFile">Validée</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="offers" class="tabcontent">
                            {{-- 1 --}}
                            <div class="row">
                                
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr style=" white-space: nowrap">
                                        </tr>
                                    </thead>
                                    <thead>
                                        <td><b>Id</b></td>
                                        <td><b>Nom du client</b></td>
                                        <td><b>Email</b></td>
                                        <td><b>Numéro</b></td>
                                        <td><b>Offre</b></td>
                                        <td><b>Opérations</b></td>
                                        <td><b> &Eacute;tat</b></td>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($offers as $item)
                                            <?php $i++; ?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->client_name }} {{ $item->client_surname }}</td>
                                                <td>{{ $item->client_email }}</td>
                                                <td>{{ $item->client_number }}</td>
                                                <td>{{ $item->client_offer }}</td>
                                                <td style="align-content: center">
                                                    @if ($item->Accpted == 0)
                                                        <button class="btn btn-outline-info btn-sm" data-toggle="modal"
                                                            data-request_id="{{ $item->id }}"
                                                            data-target="#send_to_vendor" role="button"><i
                                                                class="fas fa-paper-plane"></i></i>&nbsp;
                                                            Envoyer aux vendeur</button>
                                                    @endif
                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal"
                                                        data-request_id="{{ $item->id }}" data-target="#delete_request"
                                                        role="button"><i class="fas fa-times"></i>&nbsp;
                                                        Supprimer</button>
                                                </td>

                                                <td>
                                                    @if ($item->Accpted && !$item->hasAcceptedOffer && !$item->hasRefusedOffer)
                                                        <span>
                                                            <a class="text-info">
                                                                <i class="fas fa-check"></i>
                                                                &nbsp; Envoyé
                                                            </a>
                                                        </span>
                                                    @elseif($item->hasAcceptedOffer && $item->Accpted)
                                                        <span>
                                                            <a class="text-success">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                                &nbsp;Offre accepté
                                                            </a>
                                                        </span>
                                                    @elseif($item->hasRefusedOffer && $item->Accpted )
                                                        <span>
                                                            <a class="text-danger">
                                                                <i class="fas fa-exclamation-circle"></i>
                                                                &nbsp;Offre refusé
                                                            </a>
                                                        </span>
                                                    @else
                                                        <p style="color: gray">--</p>
                                                    @endif
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="send_to_vendor" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Envoyer l'offre
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('sendToVendor', $item->id) }}"
                                                            method="POST">
                                                            {{ csrf_field() }}
                                                            <div class="modal-body">
                                                                <p class="text-center">
                                                                <h6 style="color:rgb(67, 196, 74)">Voulez-vous vraiment
                                                                    envoyer cette offre aux vendeur?</h6>
                                                                </p>


                                                                <input type="hidden" name="request_id" id="request_id"
                                                                    value="">

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-danger">Confirmer</button>
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Fermer</button>

                                                            </div>
                                                        </form>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal fade" id="delete_request" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Supprimer l'offre
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('machines-offers.destroy', $item->id) }}"
                                                            method="POST">
                                                            {{ method_field('delete') }}
                                                            {{ csrf_field() }}
                                                            <div class="modal-body">
                                                                <p class="text-center">
                                                                <h6 style="color:red">Voulez-vous vraiment supprimer cette
                                                                    offre</h6>
                                                                </p>


                                                                <input type="hidden" name="request_id" id="request_id"
                                                                    value="">

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-danger">Confirmer</button>
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Fermer</button>

                                                            </div>
                                                        </form>

                                                    </div>

                                                </div>
                                            </div>


                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- 2 --}}



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
    <script>
        $('#delete_request').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)

            var request_id = button.data('request_id')
            var modal = $(this)

            modal.find('.modal-body #request_id').val(request_id);
        })
    </script>
    <script>
        $('#send_to_vendor').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)

            var request_id = button.data('request_id')
            var modal = $(this)

            modal.find('.modal-body #request_id').val(request_id);
        })
    </script>

@endsection
