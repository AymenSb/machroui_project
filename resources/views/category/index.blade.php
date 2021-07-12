@extends('layouts.app', [
'namePage' => 'Categories',
'class' => 'sidebar-mini',
'activePage' => 'categories',
])
@section('css')
    <style>
        ul,
        li {
            list-style-type: none;
        }

    </style>
@endsection

@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        @if (session()->has('edit'))
            <div class="alert alert-warning alert-with-icon" data-notify="container">
                <button type="button" aria-hidden="true" data-dismiss="alert" class="close">
                    <i class="now-ui-icons ui-1_simple-remove"></i>
                </button>
                <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                <span data-notify="message">{{ session()->get('edit') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-info alert-with-icon" data-notify="container">
                <button type="button" aria-hidden="true" data-dismiss="alert" class="close">
                    <i class="now-ui-icons ui-1_simple-remove"></i>
                </button>
                <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                <span data-notify="message">{{ session()->get('error') }}</span>
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
        <div class="row equal">
            @can('categories')
                @can('crée categorie')
                    <div class="col-md-6 d-flex pb-3">
                        <div class="card">
                            <div class="card-header">

                                <h3>Gestion des catégorie</h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('category.store') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" value="" placeholder="Nom de catégorie"
                                            required="">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-round">Ajouter</button>
                                    </div>
                                </form>
                                <hr class="rounded">
                                <form id="CategoryUpdaterForm">
                                    <div class="form-group">
                                        <label>Catégorie</label>
                                        <select class="form-control" required id="categoryUpdater" name="categoryUpdater">
                                            <option disabled selected value style="display:none">sélectionner une catégorie</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <div class="form-group">
                                            <a href="#updateCategory" data-effect="effect-fall" data-toggle="modal"
                                                class="btn btn-warning btn-round">
                                                Changer de nom
                                            </a>
                                            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                            <a href="#deleteCategory" data-effect="effect-fall" data-toggle="modal"
                                                class="btn btn-danger btn-round">
                                                Effacer
                                            </a>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('crée categorie')
                    <div class="col-md-6 d-flex pb-3">
                        <div class="card">
                            <div class="card-header">
                                <h3>Gestion des sous-catégorie</h3>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('subcategory.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Catégorie</label>
                                        <select class="form-control" required id="category_id" name="category_id">
                                            <option disabled selected value style="display:none">sélectionner une catégorie</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Nom de la sous-catégorie</label>
                                        <input type="text" required class="form-control" name="name" id="name" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-round">Ajouter</button>
                                    </div>
                                </form>
                                <hr class="rounded">
                                <form name="SubCategoriesUpdater">
                                    <div class="form-group">
                                        <label for="inputName" class="contro-label">Selectionnez une categorie</label>
                                        <select name="category" class="form-control SlectBox" onclick="console.log($(this).val())"
                                            onchange="console.log('change is firing')">
                                            <option value="" selected disabled>Choisissez une catégorie</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputName" class="control-label">Sous-Categorie</label>
                                        <select id="subcategory" name="subcategory" class="form-control">
                                            <option value="" selected disabled>Choisissez une sous-catégorie</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <a href="#updateSubCategory" data-effect="effect-fall" data-toggle="modal"
                                            class="btn btn-warning btn-round">
                                            Changer de nom
                                        </a>
                                        &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                        <a href="#deleteSubCategory" data-effect="effect-fall" data-toggle="modal"
                                            class="btn btn-danger btn-round">
                                            Effacer
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan



                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">Catégories</h5>

                        </div>
                        <div class="card-body all-icons">


                            <li>
                                @foreach ($categories as $category)


                                    <a data-toggle="collapse" href="#{{ $category->slug }}">
                                        <p>
                                            {{ $category->name }}
                                            <b class="caret"></b>
                                        </p>
                                    </a>

                                    <div class="collapse" id="{{ $category->slug }}">
                                        @foreach ($category->subcategory as $subcategory)
                                            <ul class="">
                                                <li>
                                                    <a data-toggle="collapse" href="#{{ $subcategory->slug }}">
                                                        <p> {{ $subcategory->name }}
                                                            <b class="caret"></b>
                                                        </p>
                                                    </a>
                                                    <div class="collapse" id="{{ $subcategory->slug }}">
                                                        <ul><b>Formations</b>

                                                            @foreach ($subcategory->formations as $formation)
                                                                <ul><a
                                                                        href="formations/{{ $formation->id }}">{{ $formation->name }}</a>
                                                                </ul>
                                                            @endforeach
                                                        </ul>

                                                        <ul><b>Machines</b>
                                                            @foreach ($subcategory->machines as $machine)
                                                                <ul><a
                                                                        href="machines/{{ $machine->id }}">{{ $machine->name }}</a>
                                                                </ul>
                                                            @endforeach
                                                        </ul>
                                                        <ul><b>Projets</b>
                                                            @foreach ($subcategory->projects as $project)
                                                                <ul><a
                                                                        href="machines/{{ $project->id }}">{{ $project->name }}</a>
                                                                </ul>
                                                            @endforeach
                                                        </ul>

                                                        <ul><b>Matières premières</b>
                                                            @foreach ($subcategory->materials as $material)
                                                                <ul><a
                                                                        href="rawmaterials/{{ $material->id }}">{{ $material->name }}</a>
                                                                </ul>
                                                            @endforeach
                                                        </ul>

                                                    </div>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </div>
                                @endforeach
                            </li>
                        </div>
                    </div>

                </div>
                {{-- Update category --}}

                <div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modifier le nom de la catégorie</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('editCategory') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <p class="text-center">
                                    <h6 style="color:rgb(0, 183, 255)">Voulez-vous changer le nom de la catégorie</h6>
                                    </p>

                                    <div class="form-group">
                                        <input type="text" required class="form-control" name="name" id="CategoryName"
                                            autocomplete="off">
                                        <input type="hidden" required class="form-control" name="id" id="CategoryId"
                                            autocomplete="off">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-round">Modifier</button>
                                    <button type="button" class="btn btn-default btn-round"
                                        data-dismiss="modal">Annuler</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- Delete category --}}
                <div class="modal fade" id="deleteCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Supprimer la catégorie</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('deleteCategory') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <p class="text-center">
                                    <h6 style="color:rgb(255, 51, 0)">Voulez-vous vraiment supprimer la catégorie</h6>
                                    </p>

                                    <div class="form-group">
                                        <input type="text" required class="form-control" disabled name="name" id="CategoryName"
                                            autocomplete="off">
                                        <input type="hidden" required class="form-control" name="name" id="CategoryName"
                                            autocomplete="off">
                                        <input type="hidden" required class="form-control" name="id" id="CategoryId"
                                            autocomplete="off">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger btn-round">Supprimer</button>
                                    <button type="button" class="btn btn-default btn-round"
                                        data-dismiss="modal">Annuler</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Update subcategoy --}}
                <div class="modal fade" id="updateSubCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modifier le nom de la sous-catégorie</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('updateSubCategory') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <p class="text-center">
                                    <h6 style="color:rgb(0, 183, 255)">Voulez-vous changer le nom de la sous-catégorie</h6>
                                    </p>

                                    <div class="form-group">
                                        <input type="text" required class="form-control" name="name" id="SubCategoryName"
                                            autocomplete="off">
                                        <input type="hidden" required class="form-control" name="id" id="SubCategoryId"
                                            autocomplete="off">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-round">Modifier</button>
                                    <button type="button" class="btn btn-default btn-round"
                                        data-dismiss="modal">Annuler</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Delete subcategory --}}
                <div class="modal fade" id="deleteSubCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Supprimer la sous-catégorie</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('DeleteSubCategory') }}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <p class="text-center">
                                    <h6 style="color:rgb(255, 51, 0)">Voulez-vous vraiment supprimer la sous-catégorie</h6>
                                    </p>

                                    <div class="form-group">
                                        <input type="text" required class="form-control" disabled name="name" id="CategoryName"
                                            autocomplete="off">
                                        <input type="hidden" required class="form-control" name="name" id="CategoryName"
                                            autocomplete="off">
                                        <input type="hidden" required class="form-control" name="id" id="CategoryId"
                                            autocomplete="off">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger btn-round">Supprimer</button>
                                    <button type="button" class="btn btn-default btn-round"
                                        data-dismiss="modal">Annuler</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            @endcan
        </div>
    </div>
@stop

@section('js')

    <script src="http://code.jquery.com/jquery-3.4.1.js"></script>

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
                            $('select[name="subcategory"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="subcategory"]').append(
                                    '<option value="' +
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

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var category_id = button.data('category_id')
            var subcategory_id = button.data('subcategory_id')
            var modal = $(this)
            modal.find('.modal-body #category_id').val(category_id);
            modal.find('.modal-body #subcategory_id').val(subcategory_id);

        })
    </script>

    <script>
        $('a[href="#updateCategory"]').click(function() {
            var category_id = $(".form-control[name=categoryUpdater]").val()
            var element = document.getElementById("categoryUpdater")
            var category_name = element.options[element.selectedIndex].text

            var modal = $('#updateCategory')
            modal.find('.modal-body #CategoryName').val(category_name)
            modal.find('.modal-body #CategoryId').val(category_id)
        })
    </script>

    <script>
        $('a[href="#deleteCategory"]').click(function() {
            var category_id = $(".form-control[name=categoryUpdater]").val()
            var element = document.getElementById("categoryUpdater")
            var category_name = element.options[element.selectedIndex].text

            var modal = $('#deleteCategory')
            modal.find('.modal-body #CategoryName').val(category_name)
            modal.find('.modal-body #CategoryId').val(category_id)
        })
    </script>

    {{-- subcategories script --}}
    <script>
        $('a[href="#updateSubCategory"]').click(function() {
            var category_id = $(".form-control[name=subcategory]").val()
            var element = document.getElementById("subcategory")
            var category_name = element.options[element.selectedIndex].text
            var modal = $('#updateSubCategory')
            modal.find('.modal-body #SubCategoryName').val(category_name)
            modal.find('.modal-body #SubCategoryId').val(category_id)
        })
    </script>

    <script>
        $('a[href="#deleteSubCategory"]').click(function() {
            var category_id = $(".form-control[name=subcategory]").val()
            var element = document.getElementById("subcategory")
            var category_name = element.options[element.selectedIndex].text

            var modal = $('#deleteSubCategory')
            modal.find('.modal-body #CategoryName').val(category_name)
            modal.find('.modal-body #CategoryId').val(category_id)
        })
    </script>


@endsection
