<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell fa-2x"></i>
          <span class="badge badge-warning navbar-badge" id="badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="dropdown-notification">
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  @push('scripts')
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>

          function getNotification(){
            var data = $.get('/admin/notifications',(data)=>{
              $("#dropdown-notification").empty();
            $("#badge").text(data.counter);
            //deposit
            $.map(data.deposits,function(v,k){
              var element = `<a href="/admin/deposits" class="dropdown-item">
                            <i class="fas fa-hand-holding-usd mr-2"></i> <span class='small'>${v.payment}</span> - <span class='small text-success'>${formatNumber(parseInt(v.outStandingCredit),2,"USD")}</span> 
                            <span class="d-block text-muted text-right text-sm">${moment(v.created_at).fromNow()}</span>
                          </a>
                          <div class="dropdown-divider"></div>`;
              $("#dropdown-notification").append(element);
            });
            //withdraw
            $.map(data.withdraws,function(v,k){
              var element = `<a href="/admin/deposits" class="dropdown-item">
                            <i class="fas fa-dollar-sign mr-2"></i> <span class='small'>${v.payment}</span> - <span class='small text-danger'>${formatNumber(parseInt(v.outStandingCredit),2,"USD")}</span> 
                            <span class="d-block text-muted text-right text-sm ">${moment(v.created_at).fromNow()}</span>
                          </a>
                          <div class="dropdown-divider"></div>`;
              $("#dropdown-notification").append(element);
            });
          });
          }
          getNotification();
          setInterval(() => {
            getNotification();
          }, 3000);

    </script>
  @endpush