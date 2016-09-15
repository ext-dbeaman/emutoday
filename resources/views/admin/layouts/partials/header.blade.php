<!-- Logo -->
<a href="/" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>EMU</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>EMU</b>-TODAY</span>
</a>
<!-- Header Navbar -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

            <!-- /.messages-menu -->
            @can('super', $currentUser)
                @include('admin.layouts.partials.notifications.bugz')

                @include('admin.layouts.partials.notifications.events')
                @include('admin.layouts.partials.notifications.announcements')
                @include('admin.layouts.partials.notifications.storys')
            @endcan
        @include('admin.layouts.partials.usermenu')

<!-- Control Sidebar Toggle Button -->
<li>
    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
</li>
</ul>
</div>
</nav>
