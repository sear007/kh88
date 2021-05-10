@extends('dashboard.app-admin')
@section('content')


<div class="card">
    <div class="card-header">
        <h3 class="card-title">Dashboard</h3>
        <div class="card-tools">
            <button onclick="getData()" class="btn btn-tool">
                <i class="fas fa-sync"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
        
                <div class="info-box-content">
                  <span class="info-box-text">Deposits Total</span>
                  <span class="info-box-number" id="deposits"></span>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar-sign"></i></span>
          
                  <div class="info-box-content">
                    <span class="info-box-text">Withdraws Total</span>
                    <span class="info-box-number" id="withdraws"></span>
                  </div>
                </div>
              </div>

              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Revenue</span>
                    <span class="info-box-number " id="revenue"></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
          
                  <div class="info-box-content">
                    <span class="info-box-text">Users Total</span>
                    <span class="info-box-number" id="users"></span>
                  </div>
                </div>
              </div>
          </div>
    </div>
</div>
@push('scripts')
    <script>
        getData();
        function getData(){
            $(".fa-sync").addClass('fa-spin');
            $.get('/admin/dataJson',function(data){
                $.map(data,function(v,k){
                    setTimeout(() => {
                        $(".fa-sync").removeClass('fa-spin');
                    }, 2000);
                    if(k!=='users'){
                        $(`#${k}`).prop('Counter',0).animate({
                            Counter: v
                        },{
                            duration: 2000,
                            easing: 'swing',
                            step: function (now) {
                                $(this).text(formatNumber(now,2,'USD'));
                            }
                        })
                    }else{
                        $(`#${k}`).text(v);
                    }
                    
                })
             })
        }
    </script>
@endpush
@endsection