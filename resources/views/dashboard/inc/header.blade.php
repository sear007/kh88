

<div class=" d-flex align-items-center justify-content-between bg-dark p-3 shadow">
<div class="btn-group">
<button type="button" id="sidebarCollapse" class="btn btn-primary">
    <i class="fa fa-bars"></i>
    <span class="d-none d-md-inline">MENU</span>
</button>
<a href="/" class="btn btn-primary">
    <i class="fa fa-dice"></i> <span class="d-none d-md-inline">Casino</span>
</a>
<a href="/" class="btn btn-primary">
    <i class="fa fa-satellite-dish"></i> <span class="d-none d-md-inline">Live Casino</span>
</a>
</div>
<div class="d-flex align-items-center">
    <a href="#" onclick="getCredit()" class="me-2"><i id="spiner-synce" class="fas fa-sync"></i></a>
    <div class="balance-top">
    <span class="username">Hello {{ Str::upper(Auth::user()->username) }}</span>
    <span class="amount"></span>
    </div>
</div>
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