<div class="nav-scroller shadow-sm">
<nav class="nav nav-underline" aria-label="Secondary navigation">
    <a class="nav-link {{ request()->is('deposit') ? "active":"" }}" href="/deposit"><i class="me-1 fas fa-hand-holding-usd"></i>Deposit</a>
    <a class="nav-link {{ request()->is('withdraw') ? "active":"" }}" href="/withdraw"><i class="me-1 fas fa-dollar-sign"></i>Withdraw</a>
    <a class="nav-link {{ request()->is('transactions') ? "active":"" }}" href="transactions"><span class="me-1 fa fa-funnel-dollar"></span> Transactions</a>
</nav>
</div>