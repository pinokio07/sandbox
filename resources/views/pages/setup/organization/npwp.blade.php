@extends('layouts.master')
@section('title') Upload NPWP @endsection
@section('page_name') Upload NPWP @endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Upload NPWP</h3>
            <div class="card-tools">              
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form id="formUpload" 
                  action="{{ route('get.npwp') }}" 
                  method="POST"
                  enctype="multipart/form-data"
                  class="needs-validation"
                  novalidate>
              @csrf              
            <div class="row">
              <div class="col-12 col-md-4">
                <div class="form-group form-group-sm">
                  <label for="file">Upload File</label>
                  <input type="file" 
                         name="file" 
                         id="file"
                         class="form-control form-control-sm"
                         required
                         accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, xls">
                </div>
              </div>              
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm elevation-2">
              <i class="fas fa-upload"></i> Upload
            </button>
          </div>
          </form>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Results</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <form method="POST"
                class="needs-validation"
                novalidate>
            @csrf          
          <div class="card-body">
            <div class="table-responsive">
              <table id="tblResults" class="table table-sm table-hover" style="width: 100%;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Org Code</th>
                    <th>Org Full Name</th>
                    <th>NPWP</th>
                    <th>Address1</th>
                    <th>Address2</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Post Code</th>
                    <th>Phone</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($items as $item)
                  <tr id="row_{{ $loop->iteration }}" 
                      class="jmlRow"
                      data-row="{{ $loop->iteration }}">
                    <td id="no_{{ $loop->iteration }}">{{ $loop->iteration }}</td>
                    <td data-search="{{ $item['org_code'] }}">                      
                      @php
                          if($item['status'] == 'Success'){
                            $org_code = $item['org_code'];                            
                          } else{
                            $org_code = '';                            
                          }
                      @endphp                      
                      @if($org_code)
                        <input type="text" 
                               name="OH_Code[]" 
                               id="OH_Code_{{ $loop->iteration }}"
                               class="form-control form-control-sm input_{{ $loop->iteration }}"
                               value="{{ $org_code }}"
                               style="min-width: 250px !important;">
                      @else
                      <select name="OH_Code[]" 
                              id="OH_Code_{{ $loop->iteration }}"
                              class="select2bs4 organization input_{{ $loop->iteration }}"
                              style="min-width:250px !important;">
                        <option value="{{ $org_code }}">{{ $org_code }}</option>
                      </select>
                      @endif
                    </td>
                    <td data-search="{{ $item['org_name'] }}">
                      <input type="text" 
                             name="OA_CompanyNameOverride[]" 
                             id="OA_CompanyNameOverride_{{ $loop->iteration }}"
                             value="{{ $item['org_name'] }}"
                             style="min-width:250px !important;"
                             class="form-control form-control-sm input_{{ $loop->iteration }}"
                             required>
                    </td>
                    <td data-search="{{ $item['npwp'] }}">
                      <input type="text" 
                             name="OA_TaxID[]" 
                             id="OA_TaxID_{{ $loop->iteration }}"
                             value="{{ $item['npwp'] }}"
                             style="min-width:150px !important;"
                             class="form-control form-control-sm input_{{ $loop->iteration }}"
                             required>
                    </td>
                    <td>
                      <input type="text" 
                             name="OA_Address1[]" 
                             id="OA_Address1_{{ $loop->iteration }}"
                             value="{{ $item['address1'] }}"
                             class="form-control form-control-sm input_{{ $loop->iteration }}"
                             required>
                    </td>
                    <td>
                      <input type="text" 
                             name="OA_Address2[]" 
                             id="OA_Address2_{{ $loop->iteration }}"
                             value="{{ $item['address2'] }}"
                             class="form-control form-control-sm input_{{ $loop->iteration }}  amount"
                             required>
                    </td>
                    <td>
                      <input type="text" 
                             name="OA_City[]" 
                             id="OA_City_{{ $loop->iteration }}"
                             value="{{ $item['city'] }}"
                             class="form-control form-control-sm input_{{ $loop->iteration }}"
                             required>
                    </td>                    
                    <td>
                      <input type="text" 
                             name="OA_State[]" 
                             id="OA_State_{{ $loop->iteration }}"
                             value="{{ $item['state'] }}"
                             class="form-control form-control-sm input_{{ $loop->iteration }}  amount"
                             required>
                    </td>
                    <td>
                      <input type="text" 
                             name="OA_PostCode[]" 
                             id="OA_PostCode_{{ $loop->iteration }}"
                             value="{{ $item['postcode'] }}"
                             class="form-control form-control-sm input_{{ $loop->iteration }}  amount"
                             required>
                    </td>
                    <td>
                      <input type="text" 
                             name="OA_Phone[]" 
                             id="OA_Phone_{{ $loop->iteration }}"
                             value="{{ $item['phone'] }}"
                             class="form-control form-control-sm input_{{ $loop->iteration }}  amount"
                             required>
                    </td>
                    <td>
                      <button type="button" 
                              class="btn btn-xs elevation-2 input_{{ $loop->iteration }} hapus"
                              data-row="{{ $loop->iteration }}">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                @empty
                  
                @endforelse
                </tbody>                
              </table>
            </div>
          </div>
          <div class="card-footer">            
            <button type="button" 
                    id="btnSave" 
                    class="btn btn-sm btn-success elevation-2">
              <i class="fas fa-save"></i> Save and Posting
            </button>            
          </div>
          </form>
        </div>
      </div>
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
    function tooltip() {
      $('[data-toggle="tooltip"]').tooltip();
    }

    var _token = "{{ csrf_token() }}";

    function getAjax(ids, no, akhir) {
      if($('#row_'+no).hasClass('jmlRow')){
        $('#no_'+no).html('POSTING');
      }
      $.ajax({
        url: "{{ route('post.npwp') }}",
        type: "POST",
        // async:false,
        data:{
          code: $('#OH_Code_'+no).val(),
          name: $('#OA_CompanyNameOverride_'+no).val(),
          npwp: $('#OA_TaxID_'+no).val(),
          address1: $('#OA_Address1_'+no).val(),
          address2: $('#OA_Address2_'+no).val(),
          city: $('#OA_City_'+no).val(),
          state: $('#OA_State_'+no).val(),
          postcode: $('#OA_PostCode_'+no).val(),
          phone: $('#OA_Phone_'+no).val(),
        },
        success(msg){          
            var baru = ids.splice(1);

            if(msg.status == 'OK'){
              $('#no_'+no).html('<span class="text-success"><i class="fas fa-check"></i></span>');
              $('#row_'+no).removeAttr('data-toggle')
                           .removeAttr('title')
                           .attr('data-toggle', 'tooltip')
                           .attr('title', msg.info);
              $('.input_'+no).prop('disabled', true);
              $('#row_'+no).removeClass('jmlRow');
              $('#no_'+baru[0]).html('POSTING');
            } else {
              $('#no_'+no).html('<span class="text-danger"><i class="fas fa-times"></i></span>');
              $('#row_'+no).removeAttr('data-toggle')
                           .removeAttr('title')
                           .attr('data-toggle', 'tooltip')
                           .attr('title', msg.info);
            } 
          tooltip();
          
          if(baru.length === 0){
            $('#btnSave').prop('disabled', false);
          } else {
            getAjax(baru, baru[0], akhir);
          }          
        }
      });
    }
    jQuery(document).ready(function(){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      var tableResults = $('#tblResults').DataTable({
                            paging: false,
                            ordering: false,
                            scrollX: true,
                            scrollY: '50vh',
                            scrollCollapse: true,
                          });
      $('.organization').select2({
        placeholder: 'Select...',
        allowClear: true,
        ajax: {          
          url: "{{ route('select2.setup.organization') }}",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: params.term, // search term
              all: 1,
            };
          },
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: (item.OH_LegacyCode ?? item.OH_Code)+" - "+item.OH_FullName,
                        id: item.OH_Code,
                    }
                })
            };
          },
          cache: true
        },        
      });      
      $(document).on('click', '.hapus', function(){
        var row = $(this).attr('data-row');

        Swal.fire({			
          title: 'Delete row?',			
          html: "Deleted Row won't be created!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancel',
          confirmButtonText: 'Yes, delete!'
        }).then((result) => {
          if (result.value) {
            $('#row_'+row).remove();
          }
        });  
      });
      $(document).on('click', '#btnSave', function(){

          var last = tableResults.row( ':last-child' ).data();
          var akhir = last[0];
          var jmlRow = $('.jmlRow').length;
          var ids = [];

          if(jmlRow > 0){
            $('#btnSave').prop('disabled', true);

            $('.jmlRow').each(function(){
              var row = $(this).attr('data-row');

              ids.push(row);
            });

            getAjax(ids, ids[0], akhir);
          }    
      });
    });
  </script>
@endsection
