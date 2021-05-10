<nav id="sidebar" class=" bg-dark">
    <h1><a href="/" class="logo">{!! logo() !!}</a></h1>
    <ul class="list-unstyled components mb-5">
        <li>
            <a href="/deposit"><span class="fa fa-hand-holding-usd"></span> Deposit</a>
        </li>
        <li>
            <a href="/withdraw"><span class="fa fa-dollar-sign"></span> Withdraw</a>
        </li>
        <li>
            <a href="/transactions"><span class="fa fa-funnel-dollar"></span> Trasnsactions</a>
        </li>
        <li>
            <a href="#" onclick="document.getElementById('formLogout').submit()"><span class="fa fa-unlock"></span> Logout</a>
            <form id="formLogout" action="/logout" method="POST">@csrf</form>
        </li>
    </ul>

    <div class="footer">
        <p class="small">
            &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved KH88
        </p>
    </div>
</nav>