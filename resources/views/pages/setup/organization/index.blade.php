@extends('layouts.master')
@section('header')
  <style>
    .add{cursor: pointer;}
    .remove{cursor: pointer;}
  </style>
@endsection
@section('title') Organizations @endsection
@section('page_name') Organizations @endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">      
      <div class="col-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Organizations</h3>
            <div class="card-tools">              
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>          
            <div class="card-body">
              <form id="formSearch" action="{{ url()->current() }}" method="get">
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <div class="form-check">
                      <input type="hidden" name="OH_IsActive" value="0">
                      <input type="checkbox" 
                              name="OH_IsActive" 
                              id="OH_IsActive" 
                              class="form-check-input"
                              value="1"
                              checked>
                      <label class="form-check-label" for="OH_IsActive">Active</label>
                    </div>
                  </div>
                </div>
              </div>
              <div id="form">
                <div class="row kriteria" id="kriteria_1">
                  <div class="col-md-3">                    
                      <select id="type_1" 
                              class="custom-select custom-select-sm tipe"
                              data-baris="1">
                        <option value="" selected disabled>Choose...</option>
                        <option value="org_name">Name</option>
                        <option value="org_unloco">Main UNLOCO</option>
                        <option value="org_code">Code</option>
                      </select>
                  </div>
                  <div class="col-md-8 mt-2 mt-md-0" id="hasil_1"></div>                        
                </div>
              </div>              
              <div class="row">                
                <div class="col-6 col-md-4">
                  <div class="row">
                    <div class="col text-primary mt-2 add">
                      <i class="fas fa-plus-circle"></i> Add
                    </div>
                    <div class="col text-danger mt-2 remove">
                      <i class="fas fa-minus-circle"></i> Remove
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button id="btnCari" type="submit" class="btn btn-sm btn-success elevation-2">
                <i class="fas fa-search"></i> Search</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              @include('table.ajax')  
            </div>
          </div>
        </div>        
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@include('forms.upload', ['action' => '#'])

@endsection

@section('footer')
  <script>
    
    function unloco(){
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
                        text: item.RL_Code,
                        id: item.RL_Code,
                    }
                })
            };
          },
          cache: true
        }
      });
    }
    var tipeForm = '<div class="row"><div class="col-4 col-md-2"><div class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" name="address[OA_RN_NKCountryCode]" id="is_domestic" value="ID"><label class="form-check-label" for="is_domestic">Domestic</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="address[OA_RN_NKCountryCode]" id="is_overseas" value="1"><label class="form-check-label" for="is_overseas">Overseas</label></div></div></div> <div class="col-4 col-md-2"><div class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" name="company[OB_IsDebtor]" id="is_receivable" value="1"><label class="form-check-label" for="is_receivable">Receivable</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="company[OB_IsCreditor]" id="is_payable" value="1"><label class="form-check-label" for="is_payable">Payable</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsSalesLead" id="is_sales" value="1"> <label class="form-check-label" for="is_sales">Sales</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsStaff" id="is_staff" value="1"> <label class="form-check-label" for="is_staff">Staff</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsTempAccount" id="is_temp" value="1"> <label class="form-check-label" for="is_temp">Temporary</label></div></div></div><div class="col-4 col-md-3"><div class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsConsignor" id="is_shipper" value="1"><label class="form-check-label" for="is_shipper">Shipper</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsConsignee" id="is_consignee" value="1"><label class="form-check-label" for="is_consignee">Consignee</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsTransportClient" id="is_transport" value="1"><label class="form-check-label" for="is_transport">Transport Client</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsWarehouseClient" id="is_warehouse" value="1"><label class="form-check-label" for="is_warehouse">Warehouse</label></div></div></div><div class="col-4 col-md-3"><div class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsShippingLine" id="is_shipping_line" value="1"><label class="form-check-label" for="is_shipping_line">Shipping Line</label></div><div class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsAirLine" id="is_carrier" value="1"><label class="form-check-label" for="is_carrier">Carrier</label></div><div class="form-group"><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsTraffic" id="is_traffic" value="1"><label class="form-check-label" for="is_traffic">Traffic</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsForwarder" id="is_forwarder" value="1"><label class="form-check-label" for="is_forwarder">Forwarder/Agent</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsBroker" id="is_broker" value="1"><label class="form-check-label" for="is_broker">Brooker</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsMiscFreightServices" id="is_service" value="1"><label class="form-check-label" for="is_service">Service</label></div><div class="form-check"><input class="form-check-input" type="checkbox" name="OH_IsCompetitor" id="is_competitor" value="1"><label class="form-check-label" for="is_competitor">Competitor</label></div></div></div></div>';
    var nameForm = '<div class="row"><div class="col-12 col-md-6"><input type="text" name="OH_FullName" class="form-control form-control-sm" placeholder="Organization Full Name"></div></div>';
    var unlocoForm = '<div class="row"><div class="col-12 col-md-6"><select name="OH_RL_NKClosestPort" class="form-control form-control-sm unloco w-100"></select></div></div>';
    var codeForm = '<div class="row"><div class="col-12 col-md-6"><input type="text" name="OH_Code" class="form-control form-control-sm" placeholder="Organization Code"></div></div>';

    function defSelect() {
      $('#type_1').val('org_name').trigger('change');
      $('#hasil_1').html(nameForm);
    }
    function msgCount(p,t) {
      var c = t - p;
      var prc = (c == 0) ? 0 : (c / t) * 100;
      prc = formatAsMoney(prc, 2);

      var msg = '<b>' + c + '</b> Completed out of <b>' + t + '</b> ( <b>'+prc+' %</b> )';

      $('#downloadinfo').removeClass('text-danger').html(msg);
    }
    function checkBatch(id) {
      $.ajax({
        url: "{{ route('dashboard.respon') }}",
        type: 'GET',
        data: {
          batch: id,
        },
        success: function(msg) {
          if(msg.status == 'OK') {
            msgCount(msg.pending,msg.total);
            if(msg.pending > 0) {
              setTimeout(() => {
                checkBatch(msg.batch);
              }, 1000);              
            } else {
              var txt = $('#downloadinfo').html();
              txt += '<br> <span class="text-success"><b>Sync Data Completed!</b></span>';

              $('#downloadinfo').html(txt);
              $('#btnSyncSubmit').prop('disabled', false);
            }
          } else {
            showError(msg.message);
            $('#downloadinfo').addClass('text-danger').html(msg.message);
          }
        },
        error:function(jqXHR){
          jsonValue = jQuery.parseJSON( jqXHR.responseText );
          toastr.error(jqXHR.status + ' || ' + jsonValue.message, "Failed!", {timeOut: 3000, closeButton: true,progressBar: true});
        }        
      });
    }
    jQuery(document).ready(function(){
      $('#dataAjax tbody').on('mouseover', 'tr', function () {
          $('[data-toggle="tooltip"]').tooltip({
              trigger: 'hover',
              html: true
          });
      });
      defSelect();

      $(document).on('click', '.add', function(){
        var last = $('.kriteria').length + 1;

        $('#form').append('<div class="row mt-2 kriteria" id="kriteria_'+last+'"><hr class="w-100 d-block d-md-none"><div class="col-md-3"><select id="type_'+last+'" class="custom-select custom-select-sm tipe" data-baris="'+last+'"><option value="" selected disabled>Choose...</option><option value="org_type">Organization Type</option><option value="org_name">Name</option><option value="org_unloco">Main UNLOCO</option><option value="org_code">Code</option></select></div><div class="col-md-8 mt-2 mt-md-0" id="hasil_'+last+'"></div>');
      });
      $(document).on('click', '.remove', function(){
        var last = $('.kriteria').length;
        if(last > 1){
          $('#kriteria_'+last).remove();
        }        
      });
      $(document).on('change', '.tipe', function() {
        var baris = $(this).data('baris');
        var tipe = $(this).find(':selected').val();
        if(tipe == 'org_type'){
          $('#hasil_'+baris).html(tipeForm);          
        } else if(tipe == 'org_name'){
          $('#hasil_'+baris).html(nameForm);
        } else if(tipe == 'org_unloco'){
          $('#hasil_'+baris).html(unlocoForm);
          unloco();
        } else if(tipe == 'org_code'){
          $('#hasil_'+baris).html(codeForm);
        }
      })
      $(document).on('submit', '#formSearch', function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $('#dataAjax').DataTable().destroy();
        $('#btnCari').prop('disabled', true);
        $.ajax({
          url: "{{ url()->current() }}",
          type: "GET",
          data: form,
          success:function(msg){
            $('#dataAjax').DataTable({
              data: msg.data,
              columns:[
                @forelse ($items as $keys => $item)
                  @if($keys == 'id')
                  {data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},                  
                  @else
                  {data: "{{$keys}}", name: "{{$keys}}"},
                  @endif
                @empty            
                @endforelse
              ]
            });             
            $('#btnCari').prop('disabled', false);
          }
        })
        
      });
      $(document).on('click', '.download', function(e){
        e.preventDefault();
        var url = $(this).attr('data-href');
        var data = $('#formSearch').serialize();

        window.open(url + '?' + data);

      })
      $(document).on('click', '.upload', function(e){
        var action = $(this).data('action');

        $('#formUpload').attr('action', action);
      });
      $(document).on('click', '.sync', function() {
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');

        Swal.fire({			
          title: 'Syncronize this organization?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancel',
          confirmButtonText: 'Yes, proceed!'
        }).then((result) => {
          if (result.value) {
            Swal.fire({
              title: "Syncronizing in Process!",
              html: "<span id='downloadinfo'>Please wait while syncronize data..</span><br>",
              timerProgressBar: true,
              allowOutsideClick: false,
              allowEscapeKey: false,
              returnFocus: false,
              didOpen: () => {
                Swal.showLoading();
                $.ajax({
                  url: "{{ route('upload.setup.organization') }}",
                  type: "POST",
                  data: {
                    id: id,
                    type: 'sync'
                  },
                  success: function(msg){
                    Swal.hideLoading();
                    if(msg.status == 'OK') {
                      checkBatch(msg.batch);
                      showSuccess(msg.message);
                    } else if(msg.status == 'PENDING') {                  
                      msgCount(msg.pending,msg.total)
                      checkBatch(msg.batch);
                    } else {
                      showError(msg.message);
                      $('#downloadinfo').addClass('text-danger').html(msg.message);
                    }      
                  },
                  error:function(jqXHR){
                    jsonValue = jQuery.parseJSON( jqXHR.responseText );
                    Swal.hideLoading();
                    $('#downloadinfo').addClass('text-danger').html('ERROR! <br>'+jqXHR.status + ' || ' + jsonValue.message);
                  }

                })
              },
            }).then((result) => {
              /* Read more about handling dismissals below */
              // if (result.dismiss === Swal.DismissReason.timer) {
              //   console.log("I was closed by the timer");
              // }
            });
          }
        });
      });
    });
  </script>
@endsection