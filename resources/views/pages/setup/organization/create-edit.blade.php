@extends('layouts.master')
@section('title') Organizations @endsection
@section('page_name') Organizations @endsection
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
            <h3 class="card-title">@if($organization->OH_PK != '') Edit @else New @endif Organizations</h3>
          </div>

            <div class="card-body">
              <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="org-detail" data-toggle="pill" href="#org-detail-content" role="tab" aria-controls="org-detail-content" aria-selected="true">Details</a>
                </li>

                @if($organization->OH_PK != '')

                  <li class="nav-item">
                    <a class="nav-link" id="org-address" data-toggle="pill" href="#org-address-content" role="tab" aria-controls="org-address-content" aria-selected="false">Address</a>
                  </li>
                  
                @endif

              </ul>
              <div class="tab-content" id="custom-content-above-tabContent">
                <div class="tab-pane fade show active" id="org-detail-content" role="tabpanel" aria-labelledby="org-detail">
                  @if($organization->OH_PK != '')
                    <form id="formOrganization" action="/setup/organization/{{$organization->OH_PK}}" method="post" autocomplete="off">
                      @method('PUT')
                    @else
                    <form id="formOrganization" action="/setup/organization" method="post" autocomplete="off">
                    @endif
                      @csrf
                  <div class="row mt-2">
                    <!-- Organization Details Form -->
                    <div class="col-md-8">
                      <div class="card card-primary card-outline">
                        <div class="card-header">
                          <h3 class="card-title">Organization Details</h3>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <!-- Organization Code -->
                            <div class="col-12 col-md-4">
                              <div class="form-group form-group-sm">
                                <label for="OH_Code">Organization Code</label>
                                <input type="text" id="OH_Code" class="form-control form-control-sm" value="{{ old('OH_Code') ?? $organization->OH_Code ?? ''}}" readonly>
                              </div>
                            </div>
                            <!-- Legacy Code -->
                            <div class="col-12 col-md-4">
                              <div class="form-group form-group-sm">
                                <label for="OH_LegacyCode">Legacy Code</label>
                                <input type="text" 
                                       name="header[OH_LegacyCode]" 
                                       id="OH_LegacyCode" 
                                       class="form-control form-control-sm" 
                                       value="{{ old('OH_LegacyCode') ?? $organization->OH_LegacyCode ?? ''}}">
                              </div>
                            </div>
                            <!-- Screening Status -->
                            <div class="col-6 col-md-2">
                              <div class="form-group form-group-sm">
                                <label for="OH_ScreeningStatus">Screening Status</label>
                                <select class="custom-select custom-select-sm" name="header[OH_ScreeningStatus]" id="OH_ScreeningStatus">
                                  <option value="0" @if($organization->OH_ScreeningStatus == false) selected @endif>No</option>
                                  <option value="1" @if($organization->OH_ScreeningStatus == true) selected @endif>Yes</option>
                                </select>
                              </div>
                            </div>
                            <!-- Organization Category -->
                            <div class="col-6 col-md-2">
                              <div class="form-group form-group-sm">
                                <label for="OH_Category">Org Category</label>
                                <select class="custom-select custom-select-sm"
                                        name="header[OH_Category]" id="OH_Category"
                                        required>
                                  {{-- <option value="" selected disabled>Select...</option> --}}
                                  <option value="BUS"
                                          @if($organization->OH_Category == 'BUS') selected @endif>Business</option>
                                  <option value="GOV"
                                          @if($organization->OH_Category == 'GOV') selected @endif>Government</option>
                                  <option value="NAT"
                                          @if($organization->OH_Category == 'NAT') selected @endif>Natural Person/Individual</option>
                                  <option value="NGO"
                                          @if($organization->OH_Category == 'NGO') selected @endif>Non Government Organization</option>
                                </select>
                              </div>
                            </div>
                            <!-- Organization Full Name -->
                            <div class="col-12">
                              <div class="form-group form-group-sm">
                                <label for="OH_FullName">Organization Full Name</label>
                                <input type="text"
                                       name="header[OH_FullName]"
                                       id="OH_FullName"
                                       class="form-control form-control-sm"
                                       placeholder="Organization Name"
                                       minlength="3"
                                       value="{{ old('header[OH_FullName]') ?? $organization->OH_FullName ?? ''}}" required>
                              </div>
                            </div>
                            <!-- UNLOCO -->
                            <div class="col-lg-6">
                              <div class="form-group form-group-sm">
                                <label for="unloco">UNLOCO</label>
                                <select name="header[OH_RL_NKClosestPort]" 
                                        id="unloco" 
                                        class="form-control form-control-sm unloco"
                                        style="width: 100%;"
                                        required>
                                  <option value="{{ $organization->OH_RL_NKClosestPort ?? '' }}"
                                          selected>
                                    {{ $organization->OH_RL_NKClosestPort ?? 'Select...' }}</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <button type="submit" class="btn btn-sm btn-success elevation-2" form="formOrganization">
                            <i class="fas fa-save"></i>
                            Save
                          </button>
                          <a href="{{ route('setup.organization') }}" class="btn btn-sm btn-default elevation-2 ml-2">Cancel</a>
                          @if($organization->OH_PK != '')
                            <a href="{{ route('setup.organization.create') }}" class="btn btn-sm btn-info elevation-2 ml-2">
                              <i class="fas fa-plus"></i> New
                            </a>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  </form>
                </div>

                @if($organization->OH_PK != '')
                  <!-- Tab Address -->
                  @include('pages.setup.organization.tab-address')
                @endif
              </div>
            </div>            
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('footer')
  <script>
    $('input:text').inputmask({
      casing: 'upper',
    });

    $('#OA_TaxID').inputmask({
      mask: "999.999.99-99999999",
    });

    jQuery(document).ready(function(){
      $(document).on('blur', '#OH_FullName', function(){
        if($(this).val() != ''){
          $.ajax({
            url: "{{ route('select2.setup.organization') }}",
            type: "GET",
            dataType: 'json',
            delay: 250,
            data: {
              q: $(this).val(),
              id: "{{ $organization->OH_PK }}",
              precise: 1,
              all: 1,
            },
            success:function(msg){
              console.log(msg)
              if(msg != ''){
                toastr.error("Organization already exists", "Failed!", {timeOut: 3000, closeButton: true,progressBar: true});
              }
            }
          })
        }        
      });      
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
                        text: item.RN_Code + " (" + item.RN_Desc.toUpperCase() + ")",
                        id: item.RN_Code,
                    }
                })
            };
          },
          cache: true
        }
      });
      $('.unloco').select2({
        placeholder: 'Select...',
        ajax: {
          url: "{{ route('select2.setup.unloco') }}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.RL_Code + " - "+ item.RL_PortName + " (" + item.RL_RN_NKCountryCode + ")",
                        id: item.RL_Code,
                        code: item.RL_RN_NKCountryCode,
                    }
                })
            };
          },
          cache: true
        }
      });
    });
  </script>
@endsection
