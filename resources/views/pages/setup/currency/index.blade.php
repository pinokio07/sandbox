@extends('layouts.master')
@section('title') Currency @endsection
@section('page_name') Currency @endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Currency</h3>
            <div class="card-tools">
              @can('create_setup_currency')
              <a href="{{url()->current()}}/create" class="btn btn-success elevation-2">
                <i class="fas fa-plus-circle"></i>
                Add                
              </a>
              @endcan
              <a href="/download/{{ Request::path() }}" class="btn btn-info elevation-2">
                <i class="fas fa-download"></i>
                Download                
              </a>
              @can('update_setup_currency')
              <button type="button"
                      class="btn btn-warning elevation-2"
                      data-toggle="modal"
                      data-target="#modal-upload">
                <i class="fas fa-upload"></i> Upload
              </button>
              @endcan
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>          
          <div class="card-body">
            @include('table.default')
          </div>          
        </div>     
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@include('forms.upload', ['action' => '/upload/'.Request::path()])
@endsection

@section('footer')
  <script>
    $(function(){
      $('#dataTable').DataTable({
        // autoWidth: false,
        responsive:true,
        initComplete: function () {
          this.api().columns([1,2,3,4,5,6]).every( function () {
            var column = this;
            var select = $('<select class="select2bs4" style="width: 100%;"><option value="">Select...</option></select>')
            .appendTo( $(column.footer(3)).empty() )
            .on( 'change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
                );
              column
              .search( val ? '^'+val+'$' : '', true, false )
              .draw();
            } );

            column.data().unique().sort().each( function ( d ) {
              if(d !== ''){
                select.append( '<option value="'+d+'">'+d+'</option>' )
              }              
            } );
          } );
        },        
      });
    });
    jQuery(document).ready(function(){
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      });       
    });
  </script>
@endsection