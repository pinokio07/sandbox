@extends('layouts.master')
@section('title') Tax @endsection
@section('page_name') Tax @endsection
@section('header')
  <style>
    label{
      margin-bottom: 0px !important;
    }
  </style>
@endsection

@section('content')
<!-- Main contents -->
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
            <h3 class="card-title">@if($tax_master->AT_PK != '') Edit @else New @endif Tax Item</h3>
          </div>
          @if($tax_master->AT_PK != '')
          <form action="/setup/tax-master/{{$tax_master->AT_PK}}" method="post" autocomplete="off">
            @method('PUT')
          @else
          <form action="/setup/tax-master" method="post" autocomplete="off">
          @endif
            @csrf
            <div class="card-body">
              <div class="row">
                <div class="col-6 col-md-2">
                  <div class="form-group form-group-sm">
                    <label for="TaxCode">Tax Type</label>
                    <input type="text" name="TaxCode" id="TaxCode"
                           class="form-control form-control-sm"
                           placeholder="Tax Code"
                           value="{{ old('TaxCode') ?? $tax_master->TaxCode ?? '' }}"
                           {{ $disabled }}>
                  </div>
                </div>
                <div class="col-6 col-md-2">
                  <div class="form-group form-group-sm">
                    <label for="TX_Code">Tax Code</label>
                    <input type="text" name="TX_Code" id="TX_Code"
                           class="form-control form-control-sm"
                           placeholder="Tax Code"
                           value="{{ old('TX_Code') ?? $tax_master->TX_Code ?? '' }}"
                           {{ $disabled }}>
                  </div>
                </div>
                <div class="col-12 col-md-2">
                  <div class="form-group form-group-sm">
                    <label for="rate">Tax Rate (%)</label>
                    <input type="text" name="rate" id="rate"
                           class="form-control form-control-sm amount"
                           placeholder="0"
                           value="{{ old('rate') ?? ($tax_master->TaxRate * 100) ?? 0 }}"
                           {{ $disabled }}>
                  </div>
                </div>                
              </div>
              <div class="row">                
                <div class="col-12 col-md-2">
                  <div class="form-group form-group-sm">
                    <label for="TX_FakturCode">Faktur Code</label>
                    <input type="text" name="TX_FakturCode" id="TX_FakturCode"
                           class="form-control form-control-sm"
                           placeholder="Faktur Code"
                           value="{{ old('TX_FakturCode') ?? $tax_master->TX_FakturCode ?? '' }}"
                           {{ $disabled }}>
                  </div>
                </div>
                <div class="col-12 col-md-2">
                  <div class="form-group form-group-sm">
                    <label for="TX_DPP">DPP (%)</label>
                    <input type="text" name="TX_DPP" id="TX_DPP"
                           class="form-control form-control-sm"
                           placeholder="DPP"
                           value="{{ old('TX_DPP') ?? $tax_master->TX_DPP ?? '' }}"
                           {{ $disabled }}>
                  </div>
                </div>
                <div class="col-12 col-md-2">
                  <div class="form-group form-group-sm">         
                    <label for="is_creditable">Credited Option</label>           
                    <div class="custom-control custom-checkbox">
                      <input type="hidden" name="TX_IsCreditable" value="0">
                      <input class="custom-control-input"
                             type="checkbox"
                             id="is_creditable"
                             name="TX_IsCreditable"
                             value="1"
                             @if($tax_master->TX_IsCreditable == true) checked @endif
                             >
                      <label for="is_creditable" class="custom-control-label">Is Creditable</label>
                    </div>
                  </div>
                </div>
              </div>              
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group form-group-sm">
                    <label for="TX_AGPayable">Payable Tax Account</label>
                    <select name="TX_AGPayable" id="TX_AGPayable"
                            class="glaccount"
                            style="width: 100%;"
                            {{ $disabled }}>
                      <option value="{{ old('TX_AGPayable') ?? $tax_master->TX_AGPayable ?? '' }}">
                        {{ optional($tax_master->glpayable)->AG_AccountNum ?? 'Select..' }}</option>
                    </select>                    
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-md-6">
                  <div class="form-group form-group-sm">
                    <label for="TX_AGReceivable">Receivable Tax Account</label>
                    <select name="TX_AGReceivable" id="TX_AGReceivable"
                            class="glaccount"
                            style="width: 100%;"
                            {{ $disabled }}>
                      <option value="{{ old('TX_AGReceivable') ?? $tax_master->TX_AGReceivable ?? '' }}">
                        {{ optional($tax_master->glreceivable)->AG_AccountNum ?? 'Select..' }}</option>
                    </select>                    
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
              <a href="/setup/tax-master" class="btn btn-sm btn-default elevation-2 ml-2">Cancel</a>
              @if($tax_master->AT_PK != '')
              <a href="/setup/tax-master/create" class="btn btn-sm btn-info elevation-2">
                <i class="fas fa-plus"></i> New</a>
              @endif
            </div>
          </form>
        </div>
      </div>
      <!-- /.col -->
      @if($tax_master->childrens)
        <div class="col-6">
          <div class="table-responsive">
            <table class="table table-sm table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tax Type</th>
                  <th>Tax Code</th>
                  <th>Payable Tax Account</th>
                  <th>Receivable Tax Account</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($tax_master->childrens as $child)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <a href="/setup/tax-master/{{ $child->id }}/edit" target="_blank">
                        {{ $child->TaxCode }}
                      </a>
                    </td>
                    <td>{{ $child->TX_Code }}</td>
                    <td>{{ $child->glpayable->AG_AccountNum }}</td>
                    <td>{{ $child->glreceivable->AG_AccountNum }}</td>
                  </tr>
                @empty
                  
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      @endif
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('footer')
  <script>
    jQuery(document).ready(function(){
      $(".amount").inputmask({
        alias: "currency",
        digits: 2,
        groupSeparator: ',',
        rightAlign: 1,
        reverse: true,
        autoUnmask: true,
        removeMaskOnSubmit: true
      });
      $('.glaccount').select2({
        placeholder: 'Select...',
        ajax: {
          url: "{{ route('select2.setup.gl-accounts') }}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.AG_AccountNum+" - "+item.AG_Description,
                        id: item.id,
                        desc: item.AG_Description
                    }
                })
            };
          },          
          cache: true
        },
        templateSelection: function(container) {
            $(container.element).attr("data-desc", container.desc);
            return container.text;
        }
      });      
    });
  </script>
@endsection
