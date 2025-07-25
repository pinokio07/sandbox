@extends('layouts.master')
@section('title') Unloco @endsection
@section('page_name') Unloco @endsection
@section('header')
  <style>
    label{
      margin-bottom: 0px !important;
    }
  </style>
@endsection

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
              <h3 class="card-title">Unloco</h3>
            </div>
            @if($item->RL_PK)
              <form action="/setup/unloco/{{$item->RL_PK}}" method="post">
                @method('PUT')
            @else
              <form action="/setup/unloco" method="post">
            @endif
                @csrf
            <div class="card-body">                              
              <div class="row">
                <div class="col-md-8">
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Detail</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group form-group-sm">
                            <label for="RL_Code">Code</label>
                            <input type="text" name="RL_Code" id="RL_Code" 
                                  class="form-control form-control-sm"
                                  placeholder="Unloco Code"
                                  value="{{ old('RL_Code') ?? $item->RL_Code ?? '' }}"
                                  required>
                          </div>                        
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group">
                            <label>Active</label>
                            <div class="form-check">
                              <input type="hidden" name="RL_IsActive" value="0">
                              <input class="form-check-input" type="checkbox"
                                    name="RL_IsActive" id="RL_IsActive"
                                    value="1"
                                    @if( old('RL_IsActive') == 1 || $item->RL_IsActive	== 1 )
                                    checked
                                    @endif>
                              <label class="form-check-label" for="RL_IsActive">Is Active</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group form-group-sm">
                            <label for="RL_PortName">Port Name</label>
                            <input type="text" name="RL_PortName" id="RL_PortName" 
                                  class="form-control form-control-sm"
                                  placeholder="Port Name"
                                  value="{{ old('RL_PortName') ?? $item->RL_PortName ?? '' }}"
                                  required>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group form-group-sm">
                            <label for="RL_IATA">IATA</label>
                            <input type="text" name="RL_IATA" id="RL_IATA" 
                                  class="form-control form-control-sm"
                                  placeholder="Port Name"
                                  value="{{ old('RL_IATA') ?? $item->RL_IATA ?? '' }}">
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group form-group-sm">
                            <label for="RL_RN_NKCountryCode">Country Code</label>
                            <select name="RL_RN_NKCountryCode"
                                    id="RL_RN_NKCountryCode"
                                    required
                                    class="form-control form-control-sm country"
                                    style="width: 100%;"
                                    required>
                                <option value="{{ $item->RL_RN_NKCountryCode ?? '' }}"
                                        selected>
                                  {{ $item->RL_RN_NKCountryCode ?? 'Select...' }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group form-group-sm">
                            <label for="RL_IATARegionCode">IATA Region Code</label>
                            <input type="text" name="RL_IATARegionCode" id="RL_IATARegionCode" 
                                  class="form-control form-control-sm"
                                  placeholder="IATA Region Code"
                                  value="{{ old('RL_IATARegionCode') ?? $item->RL_IATARegionCode ?? '' }}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Unloco Options</h3>
                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="custom-control custom-checkbox">
                        <input type="hidden" name="RL_HasAirport" value="0">
                        <input class="custom-control-input"
                               type="checkbox"
                               id="RL_HasAirport"
                               name="RL_HasAirport"
                               value="1"
                               @if($item->RL_HasAirport == true) checked @endif
                               >
                        <label for="RL_HasAirport" 
                               class="custom-control-label">
                          Has Airport</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input type="hidden" name="RL_HasSeaport" value="0">
                        <input class="custom-control-input"
                               type="checkbox"
                               id="RL_HasSeaport"
                               name="RL_HasSeaport"
                               value="1"
                               @if($item->RL_HasSeaport == true) checked @endif
                               >
                        <label for="RL_HasSeaport" 
                               class="custom-control-label">
                          Has Seaport</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input type="hidden" name="RL_HasRail" value="0">
                        <input class="custom-control-input"
                               type="checkbox"
                               id="RL_HasRail"
                               name="RL_HasRail"
                               value="1"
                               @if($item->RL_HasRail == true) checked @endif
                               >
                        <label for="RL_HasRail" 
                               class="custom-control-label">
                          Has Rail</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input type="hidden" name="RL_HasRoad" value="0">
                        <input class="custom-control-input"
                               type="checkbox"
                               id="RL_HasRoad"
                               name="RL_HasRoad"
                               value="1"
                               @if($item->RL_HasRoad == true) checked @endif
                               >
                        <label for="RL_HasRoad" 
                               class="custom-control-label">
                          Has Road</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              @can('edit_setup_unloco')              
              <button type="submit" class="btn btn-sm btn-success elevation-2">
                <i class="fas fa-save"></i> Save</button>
              @endcan
              <a href="/setup/unloco" class="btn btn-sm btn-default elevation-2 ml-2">Cancel</a>
            </div>            
            </form>
          </div>          
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection

@section('footer')
  <script>
    jQuery(document).ready(function(){
      $('.country').select2({
        placeholder: 'Select...',
        ajax: {
          url: "{{ route('select2.setup.countries') }}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.RN_Code + " (" + item.RN_Desc + ")",
                        id: item.RN_Code,
                    }
                })
            };
          },
          cache: true
        }
      });
    })
  </script>
@endsection
