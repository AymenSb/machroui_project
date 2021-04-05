{{-- <p class="type">Nom de la formation - {{ $formation->name }}</p>
<p class="base">Description - {{ $formation->description }}</p>
<p class="base">File name - {{ $attachments->file_name }}</p>

<div>
    <img src="../Attachments/Formations Attachments/{{ $formation->name }}/{{ $attachments->file_name }}">
</div> --}}

@extends('layouts.app', [
    'namePage' => 'Details',
    'class' => 'sidebar-mini',
    'activePage' => 'icons',
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
@endsection

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h5 class="title">Détails de la formation</h5>
                </div>
                <div class="card-body">
                  <form method="post" action="{{ route('profile.update') }}" autocomplete="off"
                  enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    @include('alerts.success')
                  
                      <div class="row">
                          <div class="col-md-7 pr-1">
                              <div class="form-group">
                                  <label>{{__("Nom de la formation")}}</label>
                                  <span type="text" name="name" class="form-control" >{{$formation->name}}</span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-7 pr-1">
                          <div class="form-group">
                            <label for="exampleInputEmail1">{{__("Formateur")}}</label>
                            <span type="text" name="trainer" class="form-control">{{$formation->trainer}}<span>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-7 pr-1">
                            <div class="form-group">
                                <label>{{__("Nombre des places")}}</label>
                                <span type="text" name="name" class="form-control" >{{$formation->places}}</span>
                            </div>
                        </div>
                    </div>
                  
                     <div class="card-footer ">
                      <a href="#modaldemo8" data-id="{{$formation->id}}" data-trainer="{{$formation->trainer}}" 
                        data-name="{{$formation->name}}" data-places="{{$formation->places}}" data-effect="effect-fall" data-toggle="modal"
                       class="btn btn-primary btn-round" style="color: white">Éditer</a>
                    </div>
                    <hr class="half-rule"/>
                  </form>
                </div>
                <div class="card-body">
                  <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                    @csrf
                    @method('put')
                    <div class="row">
                      <div class="col-md-7 pr-1">
                        <div class="form-group">
                          <label>{{__("Date de début")}}</label>
                          <span class="form-control " name="begin_date">{{$formation->begin_date}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-7 pr-1">
                        <div class="form-group">
                          <label>{{__("Date de fin")}}</label>
                          <span class="form-control">{{$formation->end_date}}</span>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-7 pr-1">
                      <div class="form-group">
                        <label>{{__("Description")}}</label>
                        <span class="form-control" style="font-size: 16px">{{$formation->description}}</span>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer ">
                    <a href="#modaldemo9" data-begin_date="{{$formation->begin_date}}" data-end_date="{{$formation->end_date}}" 
                      data-description="{{$formation->description}}" data-id="{{$formation->id}}" data-effect="effect-fall" data-toggle="modal"
                     class="btn btn-primary btn-round" style="color: white">Éditer</a>                  </div>
                </form>
              </div>
            </div>
          </div>
          {{-- image view --}}
            <div class="col-md-4">
              <div class="card card-user">
                <div class="card-body">
                  @empty($attachments->file_name)
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Aucune image n'a été trouvée</strong>
                 
                  </div>
              @endempty
              @isset($attachments->file_name)
              <img src="../Attachments/Formations Attachments/{{ $formation->name }}/{{ $attachments->file_name }}">
              @endisset
                </div>
                <hr>
                <div class="button-container">
                    <div class="card-footer ">
                      <a href="#modaldemo10" data-id="{{$formation->id}}" 
                        data-effect="effect-fall" data-toggle="modal"
                       class="btn btn-primary btn-round" style="color: white">Éditer</a>                      
                      </div> 
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    {{-- Edit name & trainer & places --}}
    <div class="modal fade" id="modaldemo8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
         <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit product</h5>
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

                        <input type="hidden" class="form-control" name="id" id="id" value="">

                        <input type="text" class="form-control" name="name" id="name" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                      <label for="title">Formateur</label>


                      <input type="text" class="form-control" name="trainer" id="trainer" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="title">Nombre de places</label>


                    <input type="number" class="form-control" name="places" id="places" autocomplete="off" >
                </div>
                    

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

  {{-- edit dates and description --}}

<div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
         <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action='{{ route('formations.update',$formation->id) }}' method="post">
                {{ method_field('patch') }}
                {{ csrf_field() }}
                <div class="modal-body">

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
                    <button type="submit" class="btn btn-primary">Edit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

  {{-- edit photo modal--}}
    
<div class="modal fade" id="modaldemo10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
 <div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change l'image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action='{{ route('attachment.update',$formation->id) }}' method="post">
        {{ method_field('patch') }}
        {{ csrf_field() }}
        <div class="modal-body">

            <input type="hidden" class="form-control" name="id" id="id" value="">
            <p class="text-danger">* La format de pièce jointe est jpeg, .jpg, .png</p>
            <h5 class="card-title">Pièces jointes</h5>

            <div class="col-sm-12 col-md-12">
                <input type="file" name="image" id="image" class="dropify" accept=".jpg, .png, image/jpeg, image/png"
                    data-height="70" required />
            </div><br>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Edit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>
</div>
</div>
  </div>
@stop

@section('js')
{{-- 1 --}}
<script>
	$('#modaldemo8').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var name = button.data('name')
		var trainer = button.data('trainer')
		var places = button.data('places')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #name').val(name);
		modal.find('.modal-body #trainer').val(trainer);
		modal.find('.modal-body #places').val(places);
	})
</script>
{{-- 1 --}}

{{-- 2 --}}
<script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var begin_date = button.data('begin_date')
		var end_date = button.data('end_date')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #begin_date').val(begin_date);
		modal.find('.modal-body #end_date').val(end_date);
		modal.find('.modal-body #description').val(description);
	})
</script>
{{-- 2 --}}


{{-- 3 --}}
<script>
	$('#modaldemo10').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
	})
</script>
{{-- 3 --}}

<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../../plugins/jquery-ui/jquery-ui.js"></script>

<script>
 var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
</script>

@stop

