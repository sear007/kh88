<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <span class="brand-text font-weight-light">www.KH88.xyz</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="/admin/deposits" class="nav-link">
                    <i class="nav-icon fas fa-hand-holding-usd"></i>
                    <p>Deposit <span class="right badge badge-primary">0</span></p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/withdraws" class="nav-link">
                    <i class="nav-icon fas fa-dollar-sign"></i>
                    <p>Withdraw <span class="right badge badge-primary">0</span></p>
                </a>
            </li>
            <li class="nav-item">
              <a onclick="document.getElementById('logout').submit()" href="#" class="nav-link">
                  <i class="nav-icon fas fa-unlock"></i>
                  <p>Logout</span></p>
              </a>
              <form action="/logout" id="logout" method="post">@csrf</form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>