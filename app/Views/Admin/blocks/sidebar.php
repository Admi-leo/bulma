<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="/admin" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Administration</b></span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <?php include 'status.php'; ?>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">Навигация</li>
      <!-- Optionally, you can add icons to the links -->
      <li><a href="/admin/photos"><i class="fa fa-image"></i> <span>Все картинки</span></a></li>
      <li><a href="/admin/categories"><i class="fa fa-list"></i> <span>Категории</span></a></li>
      <li><a href="/admin/users"><i class="fa fa-group"></i> <span>Пользователи</span></a></li>
      <li><a href="/"><i class="fa fa-home"></i> <span>На сайт</span></a></li>
      <li><a href="/logout"><i class="fa fa-sign-out"></i> <span>Выйти</span></a></li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
