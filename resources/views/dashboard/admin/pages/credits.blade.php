@extends('dashboard.app-admin')
@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Deposit Request</h3>
    </div>
    <!-- /.card-header -->
    <style>
        .table thead th{
            font-weight: normal;
            font-size: 11pt;
            text-align: center;
            color: #bead61;
        }
        .table tbody td{
            font-size: 12pt;
            color: #444443;
        }
    </style>
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped table-sm">
        <thead>
        <tr>
          <th>Username</th>
          <th>Payment</th>
          <th>Credit</th>
          <th>Before Credit</th>
          <th>Type</th>
          <th>OutStanding Credit</th>
          <th>Transaction</th>
          <th><i class="fas fa-clock"></i></th>
          <th><i class="fas fa-cogs"></i></th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
@if (session()->has('success'))
@push('scripts')
<script>
    Swal.fire({
        text:'{{ session()->get("success") }}',
        icon: "success",
        showCancelButton: false,
        confirmButtonColor: '#17a234',
        confirmButtonText: 'Okay'
    });
</script>
@endpush
@endif
@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script>
    $(function () {
        $.get("{{ route('creditsJson') }}",function(data){
            console.log(data);
        })
      $("#example1").DataTable({
        "processing": true,
        'serverSide': true,
        "pageLength": 25,
        ajax: "{{ route('creditsJson') }}",
        columns: [
            {"data":"username"},
            {"data":"payment"},
            {"data":"credit"},
            {"data":"beforeCredit"},
            {"data":"outStandingCredit",render: function(data){
                if(data<0){
                    return "<span class='text-danger'>Withdraw</span>"
                }
                return "<span class='text-success'>Deposit</span>"
            }},
            {"data":"outStandingCredit"},
            {"data":"transaction"},
            {"data": "created_at",render: function(data){
                return moment(data).fromNow();
            }},
            {"data": "id",render:function(){
                var element = `
                <div class="btn-group btn-block">
                    <form></form>
                    <button data-toggle="tooltip" title="Approve" class="btn btn-sm btn-default"><i class="fas fa-check text-success"></i></button>
                    <button data-toggle="tooltip" title="Remove" class="btn btn-sm btn-default"><i class="fas fa-trash text-danger"></i></button>
                </div>
                `;
                return element;
            }}
        ],
    });
      $('.destroy').click(function(e){
        let $form = $(this).closest('form');
        var transaction = $(this).attr('data-transaction');
        var payment = $(this).attr('data-payment');
        var amount = $(this).attr('data-amount');
        var time = $(this).attr('data-time');
        var status = $(this).attr('data-status');
        Swal.fire({
            html: `
            <table class="text-left table-sm table table-bordered">
                <tr>
                    <td>Amount:</td>
                    <td>USD ${amount}</td>
                </tr>
                <tr>
                    <td>Payment:</td>
                    <td>${payment}</td>
                </tr>
                <tr>
                    <td>ID:</td>
                    <td>${transaction}</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>${time}</td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>${status}</td>
                </tr>
            </table>
            <h2>Do you want to remove ?</h2>
            `,
            icon: "danger",
            showCancelButton: false,
            confirmButtonColor: '#84212a',
            confirmButtonText: 'Yes, Remove Now!'
            }).then((result) => {
            if (result.isConfirmed) {
                $form.submit();
            }
        })
        e.preventDefault();;
      })
      $('.approve').click(function(e){
        let $form = $(this).closest('form');
        var transaction = $(this).attr('data-transaction');
        var payment = $(this).attr('data-payment');
        var amount = $(this).attr('data-amount');
        var time = $(this).attr('data-time');
        Swal.fire({
            html: `
            <table class="text-left table-sm table table-bordered">
                <tr>
                    <td>Amount:</td>
                    <td>USD ${amount}</td>
                </tr>
                <tr>
                    <td>Payment:</td>
                    <td>${payment}</td>
                </tr>
                <tr>
                    <td>ID:</td>
                    <td>${transaction}</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>${time}</td>
                </tr>
            </table>
            <h2>Do you want to approve ?</h2>
            `,
            icon: "success",
            showCancelButton: false,
            confirmButtonColor: '#17a234',
            confirmButtonText: 'Yes, Aprrove!'
            }).then((result) => {
            if (result.isConfirmed) {
                $form.submit();
            }
        })

        e.preventDefault();;
      });
    });
  </script>
@endpush
@push('css')
      <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@endsection