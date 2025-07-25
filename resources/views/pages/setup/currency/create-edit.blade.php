@extends('layouts.master')
@section('title') Currency @endsection
@section('page_name') Currency @endsection
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
            <h3 class="card-title">@if($currency->id != '') Edit @else New @endif Currency</h3>            
          </div>
          @if($currency->id != '')
          <form action="/setup/currency/{{$currency->id}}" method="post" autocomplete="off">
            @method('PUT')
          @else
          <form action="/setup/currency" method="post" autocomplete="off">
          @endif
            @csrf
            <div class="card-body">              
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">Container Type Details</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group form-group-sm">
                        <label for="RX_Code">Currency Code</label>
                        <input type="text" name="RX_Code" id="RX_Code"
                               class="form-control form-control-sm"
                               value="{{ old('RX_Code') ?? $currency->RX_Code ?? '' }}"
                               placeholder="Currency Code"
                               required
                               {{ $disabled }}>
                      </div>
                      <div class="form-group form-group-sm">
                        <label for="RX_Symbol">Symbol</label>
                        <input type="text" name="RX_Symbol" id="RX_Symbol"
                               class="form-control form-control-sm"
                               value="{{ old('RX_Symbol') ?? $currency->RX_Symbol ?? '' }}"
                               placeholder="Symbol"
                               required
                               {{ $disabled }}>
                      </div>
                      <div class="form-group form-group-sm">
                        <label for="RX_Desc">Description</label>
                        <input type="text" name="RX_Desc" id="RX_Desc"
                               class="form-control form-control-sm"
                               value="{{ old('RX_Desc') ?? $currency->RX_Desc ?? '' }}"
                               placeholder="Description"
                               required
                               {{ $disabled }}>
                      </div>
                      <div class="form-group form-group-sm">
                        <label for="RX_IsActive">Currency Status</label>
                        <div class="form-check">
                          <input type="hidden" name="RX_IsActive" value="0">
                          <input class="form-check-input" type="checkbox" 
                                 name="RX_IsActive" id="RX_IsActive" value="1"
                                 @if(old('RX_IsActive') == 1 || $currency->RX_IsActive == 1) checked @endif
                                 {{ $disabled }}>
                          <label class="form-check-label" for="RX_IsActive">Is Active</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group form-group-sm">
                        <label for="RX_UnitName">Major Unit</label>
                        <input type="text" name="RX_UnitName" id="RX_UnitName"
                               class="form-control form-control-sm"
                               value="{{ old('RX_UnitName') ?? $currency->RX_UnitName ?? '' }}"
                               placeholder="Major Unit"
                               required
                               {{ $disabled }}>
                      </div>
                      <div class="form-group form-group-sm">
                        <label for="RX_SubUnitName">Sub Unit</label>
                        <input type="text" name="RX_SubUnitName" id="RX_SubUnitName"
                               class="form-control form-control-sm"
                               value="{{ old('RX_SubUnitName') ?? $currency->RX_SubUnitName ?? '' }}"
                               placeholder="Sub Unit"                               
                               {{ $disabled }}>
                      </div>
                      <div class="form-group form-group-sm">
                        <label for="RX_SubUnitRatio">Minor Unit Ratio</label>
                        <input type="number" name="RX_SubUnitRatio" id="RX_SubUnitRatio"
                               class="form-control form-control-sm"
                               value="{{ old('RX_SubUnitRatio') ?? $currency->RX_SubUnitRatio ?? '' }}"
                               placeholder="0"                               
                               {{ $disabled }}>
                      </div>
                      <div class="form-group form-group-sm">
                        <label for="RX_ISOSubUnitRatio">ISO Minor Unit Ratio</label>
                        <input type="number" name="RX_ISOSubUnitRatio" id="RX_ISOSubUnitRatio"
                               class="form-control form-control-sm"
                               value="{{ old('RX_ISOSubUnitRatio') ?? $currency->RX_ISOSubUnitRatio ?? '' }}"
                               placeholder="0"                               
                               {{ $disabled }}>
                      </div>
                    </div>                    
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              @if($disabled != 'disabled')
              <button type="submit" class="btn btn-sm btn-success elevation-2">
                <i class="fas fa-save"></i> Save</button>
              @else
              <a href="{{ url()->current() }}/edit" class="btn btn-sm btn-warning elevation-2">
                <i class="fas fa-edit"></i> Edit</a>
              @endif
              <a href="/setup/currency" class="btn btn-sm btn-default elevation-2 ml-2">Cancel</a>            
            </div>
          </form>
        </div>     
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection