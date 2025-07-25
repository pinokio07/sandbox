@extends('layouts.master')
@section('title') Country @endsection
@section('page_name') Country @endsection

@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if (count($errors) > 0)
        <div class="row">
          <div class="col-12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          </div>
        </div>
      @endif
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Country</h3>
            </div>
            @if(!$country->id == '')
              <form action="/setup/countries/{{$country->id}}" method="post">
                @method('PUT')
            @else
              <form action="/setup/countries" method="post">
            @endif
                @csrf
            <div class="card-body">              
              <div class="row">
                <div class="col-4 col-md-3">
                  <div class="form-group form-group-sm">
                    <label for="CO_Code">Country Code</label>
                    <input type="text" class="form-control form-control-sm" name="CO_Code" id="CO_Code" required value="{{ old('CO_Code') ?? $country->CO_Code ?? '' }}">
                  </div>
                </div>
                <div class="col-8 col-md-6">
                  <div class="form-group form-group-sm">
                    <label for="CO_Name">Country Name</label>
                    <input type="text" class="form-control form-control-sm" name="CO_Name" id="CO_Name" required value="{{ old('CO_Name') ?? $country->CO_Name ?? '' }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-sm btn-success elevation-2">Save</button>
            </div>
            </form>
          </div>          
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
