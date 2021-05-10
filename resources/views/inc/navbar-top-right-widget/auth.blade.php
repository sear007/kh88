<div class="d-flex justify-content-end align-items-center">
@if (Auth::user()->type === 'admin')
<div class="me-2 flex-fill">
  <a href="/admin/dashboard">Dashboard</a>
</div>
@else
<div class="me-2 flex-fill">
  <a href="#" onclick="getCredit()"><i id="spiner-synce" class="fas fa-sync"></i></a>
</div>
<div class="me-2 flex-fill">
  <div class="balance-top">
    <span class="username">{{ Auth::user()->username }}</span>
    <span class="amount"></span>
  </div>
</div>
<div class="me-2 flex-fill">
  <div class="dropdown">
    <button class="btn-sm btn btn-primary" data-bs-toggle="dropdown" id="#profile">
      <i class="fas fa-dollar-sign"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-label="profile">
     <li><a href="/deposit" class="dropdown-item">Deposit</a></li>
     <li><a href="/withdraw" class="dropdown-item">Withdraw</a></li>
     <li><a href="/transactions" class="dropdown-item">Transaction</a></li>
    </ul>
  </div>
</div>
<div class="me-2 flex-fill">
  <div class="dropdown">
    <button class="btn-sm btn btn-primary" data-bs-toggle="dropdown" id="#profile">
      <i class="fas fa-user"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-label="profile">
      <li><a href="/dashboard" class="dropdown-item">Dashboard</a></li>
      <li><a href="#" onclick="document.getElementById('formLogout').submit()" class="dropdown-item">Sign Out</a></li>
      <form id="formLogout" method="POST" action="/logout">@csrf</form>
    </ul>
  </div>
</div>
@endif    
</div>
  @push('scripts')
      <script>
          getCredit();
          function getCredit(){
            $.get('/credit', function(data){
                $("#spiner-synce").addClass('fa-spin');
                $(".amount").hide().html(formatNumber(parseInt(data.Credit),2,"USD")).fadeIn('fast');
                setTimeout(() => {
                    $("#spiner-synce").removeClass('fa-spin');
                }, 500);
            });
          }
      </script>
  @endpush