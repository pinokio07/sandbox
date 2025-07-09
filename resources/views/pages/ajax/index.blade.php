@extends('layouts.master')
@section('title') {{ Str::title(Request::segment(1)) }} @endsection
@section('page_name') {{ Str::title(Request::segment(1)) }} @endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{{ Str::title(Request::segment(1)) }} Page from contoller</h3>
          </div>
          <div class="card-body">
            <table class="table table-sm table-striped" id="table-user">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Username</th>
                </tr>
              </thead>
            </table>
            <input type="number" class="jumlah" id="jumlah_1" data-id="1">
            <input type="number" id="harga_1" value="500" readonly>
            <hr>
            <input type="text" id="total" readonly>
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
    jQuery(document).ready(function(){
      $('#table-user').DataTable( {
          ajax: "{{ route('ajax') }}",
          columns: [ 
            {data: "id"},
            {data: "name"},
            {data: "username"},
           ]
      } );

      $(document).on('input paste change', '.jumlah', function () {
        var value = $(this).val();
        var id = $(this).attr('data-id');

        var harga = $('#harga_'+id).val();

        var total = value * harga;

        $('#total').val(total);

        console.log(total);
      });
    });
  </script>
@endsection