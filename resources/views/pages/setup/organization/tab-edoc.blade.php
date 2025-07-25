<div class="tab-pane fade" id="org-edoc-content" role="tabpanel" aria-labelledby="org-edoc">
  <div class="row mt-2">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">E-Doc Lists</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool"
                    id="btnUpload" 
                    data-toggle="modal" 
                    data-target="#modal-edocs">
              <i class="fas fa-upload"></i>
            </button>
            <button type="button" id="btnResync" class="btn btn-tool">
              <i class="fas fa-sync"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group form-group-sm">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="showDeleted">
                  <label class="form-check-label" for="showDeleted">Show Deleted</label>
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-sm text-nowrap" id="tableEdoc" style="width: 100%;">
              <thead>
                <tr>
                  <th>Date Local</th>
                  <th>Date UTC</th>
                  <th>Doc Type</th>
                  <th>Description</th>
                  <th>File Name</th>
                  <th>Created By</th>
                  <th>Last Edited By</th>
                  <th>Deleted By</th>
                  <th>Deleted UTC</th>
                  <th>Deleted Local</th>
                  <th>Published</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>          
        </div>
      </div>
    </div>    
  </div>
</div>

<div class="modal fade" id="modal-edocs">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edocs</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formEdocs" method="post" 
            action="{{ route('setup.organization.newedocs') }}"
            enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="method" value="POST">
        <input type="hidden" name="organization_id" value="{{ $organization->id }}">
      <div class="modal-body">
        <!-- File -->
        <div class="form-group form-group-sm">
          <label for="file">File</label>
          <input type="file" name="file" id="file" 
                 class="form-control form-control-sm"
                 accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*"
                 required>
        </div>
        <!-- Doc Type -->
        <div class="form-group form-group-sm">
          <label for="doc_type_id">Doc Type</label>         
          <select name="doc_type_id" id="doc_type_id" 
                  style="width: 100%;"
                  required>
            <option selected disabled value="">Select...</option>
          </select>
        </div>
        <!-- Doc Num -->
        <div class="form-group form-group-sm">
          <label for="doc_num">Doc Number</label>         
          <input type="text"
                 name="doc_num"
                 id="doc_num"
                 class="form-control form-control-sm"
                 placeholder="Document Number"
                 required>
        </div>
        <!-- Valid From -->
        <div class="form-group form-group-sm">
          <label for="valid_from">Valid From</label>         
          <input type="date"
                 name="valid_from"
                 id="valid_from"
                 class="form-control form-control-sm"
                 value="{{ today()->toDateString() }}"
                 required>
        </div>
        <!-- Valid Till -->
        <div class="form-group form-group-sm">
          <label for="valid_till">Valid Until</label>         
          <input type="date"
                 name="valid_till"
                 id="valid_till"
                 class="form-control form-control-sm"
                 value="{{ today()->toDateString() }}"
                 required>
        </div>
        <!-- Publish -->
        <div class="form-group form-group-sm">          
          <div class="custom-control custom-checkbox">
            <input type="hidden" name="is_published" value="0">
            <input class="custom-control-input" 
                   type="checkbox" 
                   id="is_published" 
                   name="is_published" 
                   value="1">
            <label for="is_published" class="custom-control-label">Is Published</label>
          </div>          
        </div>        
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success elevation-2 float-right">
          <i class="fas fa-save"></i> Save
        </button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-logs">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edoc Logs</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-sm" id="tableLogs" style="width: 100%;">
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Download Local</th>
                <th>Download UTC</th>
              </tr>
            </thead>
            <tbody id="logsBody">

            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
  jQuery(document).ready(function(){
    var tabelEdocs = $('#tableEdoc').DataTable( {
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('setup.organization.edocs', $organization->id) }}",
        columns:[
          {data: "date_local"},
          {data: "date_utc"},
          {data: "doc_type"},
          {data: "description"},
          {data: "file"},
          {data: "created_by"},
          {data: "edited_by"},
          {data: "deleted_by"},
          {data: "deleted_at_utc"},
          {data: "deleted_at_local"},
          {data: "published", className: "text-center"},
          {data: "action", className: "text-center"}
        ]
    });

    $('#modal-edocs').on('shown.bs.modal', function () {
      $('#doc_type_id').select2({
        placeholder: 'Select...',
        dropdownParent: $('#modal-edocs .modal-content'),
        ajax: {
          url: "{{ route('select2.doctype') }}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.RT_DocType+" - "+item.RT_Desc,
                        id: item.id,
                    }
                })
            };
          },          
          cache: true
        }
      });      
    });    

    $(document).on('submit', '#formEdocs', function(e){
      e.preventDefault();
      var action = $(this).attr('action');

      $.ajax({
        url: action,
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success:function(msg){
          if(msg == "FORBIDDEN"){
            toastr.error("File Type is not Allowed", "Failed!", {timeOut: 6000, closeButton: true});
          } else {
            tabelEdocs.draw();
            $("#formEdocs")[0].reset();
            $('#modal-edocs').modal('hide');
            toastr.success("Upload Success", "Sukses!", {timeOut: 6000, closeButton: true})
            console.log(msg);
          }          
        }
      })
    });

    $(document).on('click', '#btnResync', function(){
      tabelEdocs.draw();
    });

    $(document).on('change', '#showDeleted', function(){
      if($(this).is(':checked')){
        $('#tableEdoc').DataTable().destroy();
        
        $('#tableEdoc').DataTable( {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "/setup/organization/edocs/{{ $organization->id }}?deleted=show",
            columns:[
              {data: "date_local"},
              {data: "date_utc"},
              {data: "doc_type"},
              {data: "description"},
              {data: "file"},
              {data: "created_by"},
              {data: "edited_by"},
              {data: "deleted_by"},
              {data: "deleted_at_utc"},
              {data: "deleted_at_local"},
              {data: "published", className: "text-center"},
              {data: "action", className: "text-center"}
            ]
        });
      } else {
        tabelEdocs.draw();
      }
    })

    $(document).on('change', '.stateedocs', function(){
      var id = $(this).data('id');
      var _token = "{{ csrf_token() }}";
      var _method = 'PUT';

      if($(this).is(':checked')){
        var val = 1;
      } else {
        var val = 0;
      }

      $.ajax({
        url: "{{ route('setup.organization.edocstate') }}",
        type: "POST",
        data: {
          _token: _token,
          _method: _method,
          id: id,
          val: val
        },
        success: function(msg){
          tabelEdocs.draw();
          toastr.success("Change State Success", "Sukses!", {timeOut: 6000, closeButton: true})
          console.log(msg);
        }
      });
    })

    $(document).on('click', '.hapusEdocs', function(){
      var id = $(this).data('id');

      Swal.fire({			
				title: 'Are you sure?',			
				html: "This will be permanently delete Document!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Cancel',
				confirmButtonText: 'Yes, delete!'
			}).then((result) => {
				if (result.value) {
          $.ajax({
            url: "{{ route('setup.organization.deledocs') }}",
            type: "GET",
            data: {              
              id: id
            },
            success:function(msg){
              tabelEdocs.draw();
              toastr.success("Remove eDocs Success", "Sukses!", {timeOut: 6000, closeButton: true})
              console.log(msg);
            }
          });
				}
			});
    });

    $(document).on('click', '.viewLogs', function(){
      var id = $(this).data('id');

      $.ajax({
        url: "{{ route('setup.organization.edoclogs') }}",
        type: "GET",
        data:{
          id:id
        },
        success:function(msg){
          $('#tableLogs').DataTable().destroy();
          $('#tableLogs #logsBody').html(msg);
          $('#tableLogs').DataTable();
        }
      })
    });
    
  });
</script>