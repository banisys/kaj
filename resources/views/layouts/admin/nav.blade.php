<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom" style="padding-top: 5px;padding-bottom: 0;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav mr-auto">
         <form method="POST" action="{{ route('admin.auth.logout') }}">
                        @csrf
                        <button style="background-color: unset;border: unset;color: #dc3545;font-size: 20px;margin-top:4px" type="submit"><i
                                    class="fa fa-power-off"></i></button>
                    </form>
    </ul>
</nav>