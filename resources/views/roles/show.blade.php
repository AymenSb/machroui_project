@extends('layouts.app', [
    'namePage' => 'Icons',
    'class' => 'sidebar-mini',
    'activePage' => 'icons',
])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Tout les privilège de <a class="text-info">{{$role->name}}</a></h5>
            <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">Retoure</a>

            </p>
          </div>
          <div class="card-body">
            <div class="main-content-label mg-b-5">
                
            </div>
            <div class="row">
                <!-- col -->
                <div class="col-lg-4">
                    <ul id="treeview1">
                        <li><a class="text-success">{{ $role->name }}</a>
                            <ul>
                                @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                <li>{{ $v->name }}</li>
                                @endforeach
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /col -->
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
@endsection