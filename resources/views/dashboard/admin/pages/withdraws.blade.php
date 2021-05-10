@extends('dashboard.app-admin')
@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Withdraws Request</h3>
      <div class="card-tools">
          <button onclick="reload();" type="button" class="btn btn-tool"><i class="fas fa-sync"></i></button>
      </div>
    </div>
    <div class="card-body">
      <table id="withdraw-table" class="table table-bordered table-striped table-sm">
        <thead>
        <tr>
          <th>Username</th>
          <th>Payment</th>
          <th>Last Payment</th>
          <th>Credit</th>
          <th>OutStanding Credit</th>
          <th>Request On</th>
          <th><i class="fas fa-info"></i></th>
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
    getData();
    function reload(){
        $(function(){
            $("#withdraw-table").DataTable().ajax.reload();
        })
    }
    function getData(){
        $(function(){
            var table = $("#withdraw-table").DataTable({
            "processing": true,
            'serverSide': true,
            "pageLength": 25,
            ajax: "{{ route('withdrawsJson') }}",
            columns: [
                {"data":"username"},
                {"data":"payment"},
                {"data":"lastPayment"},
                {"data":"credit",render:function(data){
                    return formatNumber(parseInt(data),2,"USD");
                }},
                {"data":"outStandingCredit",render:function(data){
                    return formatNumber(parseInt(data),2,"USD");
                }},
                {"data": "created_at",render: function(data){
                    return moment(data).fromNow();
                }},
                {"data": "status",render: function(data,type,row){
                    if(data > 0){
                        return `<span class="fas fa-check text-success"></span>`;
                    }
                    return `<span class=" spin-${row.id} fas fa-sync fa-spin"></span>`;
                }},
                {"data": "id",render:function(data,type,row){
                    var element = `
                    <div class="btn-group btn-block" id="td-${data}">
                        <form></form>
                        <button  onclick="approve(${data},'${row.payment}','${row.lastPayment}','${row.created_at}','${row.transaction}', ${row.outStandingCredit})" data-toggle="tooltip" title="Approve" class="btn btn-sm btn-default"><i class="fas fa-check text-success"></i></button>
                        <button onclick="remove(${data})"  data-toggle="tooltip" title="Remove" class="btn btn-sm btn-default"><i class="fas fa-trash text-danger"></i></button>
                    </div>
                    `;
                return element;
            }}
        ],
    });
        })
    }
      
    function remove(id){
        Swal.fire({
            icon:"info",
            title: "Are you sure to delete?",
            confirmButtonText:"Delete Now",
            confirmButtonColor:"red",
        }).then((result)=>{
            if(result.isConfirmed){
                Swal.fire({icon:"success",confirmButton:true});
                $(`#td-${id}`).closest('tr').remove();
                $.ajax({
                    url:"{{ route('destroy_withdraw') }}",
                    method:"POST",
                    data:{"_token":$("meta[name='csrf_token']").attr('content'),"id":id},
                });
            }
        });
    }
    function approve(id,payment,lastPayment,created_at,transaction,outStandingCredit){
        Swal.fire({
            "html":`<table class="table table-striped text-left">
            <tr><td>OutStanding</td><td> ${formatNumber(outStandingCredit,2,"USD")} </td></tr>
            <tr><td>Payment</td><td> ${payment} </td></tr>
            <tr><td>Payment</td><td> ${lastPayment} </td></tr>
            <tr><td>Transaction</td><td> ${transaction.toUpperCase()} </td></tr>
            <tr><td>Request On</td><td> ${moment(created_at).fromNow()} </td></tr>
            </table>`,
            "icon":"success",
            confirmButtonText:"Approve Now",
        }).then((result) =>{
            if(result.isConfirmed){
                $.ajax({
                    url:`{{ route('approve_withdraw') }}`, 
                    method:"POST",
                    data:{"_token":$("meta[name='csrf_token']").attr('content'),"id":id},
                    success:function(data){
                        $(`.spin-${id}`).removeClass('fa-spin');
                        $(`.spin-${id}`).removeClass('fa-sync');
                        $(`.spin-${id}`).addClass('fa-check');
                        $(`.spin-${id}`).addClass('text-success');
                        Swal.fire({
                            icon:"success",
                            confirmButtonText:data,
                        });
                    }
                });
            }
        });
    }
  </script>
@endpush
@push('css')
      <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@endsection