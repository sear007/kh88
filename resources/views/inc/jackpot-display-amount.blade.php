<div class="main py-3 bg-dark d-none d-lg-block">
    <div class="jackpot-container">
        <span class="img-jackpot"></span>
        <div class="center-container">
            <div class="jackpot-light-circle"></div>
        </div>
    
        <div class="jackpot">
            <span id="jackpot-counter" class="text-white"></span>
        </div>
        <div class="star star-1"></div>
        <div class="star star-2"></div>
        <div class="star star-3"></div>
        <div class="star star-4"></div>
        <div class="star star-5"></div>
        <div class="star star-6"></div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/jackpot-amount.css') }}">
@endpush
@push('scripts')
<script>
new CountUp('jackpot-counter', 2124814, 2924814, 2, 100000000, '').start();
</script>
@endpush