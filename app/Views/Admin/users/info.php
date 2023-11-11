<?php $this->layout('Admin/template') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content container-fluid">

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Админ-панель</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div>
            <div class="box-header">
              <h2 class="box-title" style="font-size:28px;"><?= $user['username']; ?></h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-6">
                <div style="display:flex; justify-content: space-between;">
                  <div style="line-height:30px">
                    Email: <?= $user['email']; ?> <i>(<?= isset($user['verified']) ? "подтверждена" : "не подтверждена"; ?>)</i><br>
                    Роль: <?= getRole($user['roles_mask']); ?><br>
                    Статус: <?= isset($user['status']) ? "Активный" : "Забанен"; ?><br>
                    Регистрация: <u><?= uploadedDate($user['registered']); ?></u><br>
                    Последний вход: <u><?= uploadedDate($user['last_login']); ?></u><br>
                  </div>
                  <div class="">
                    <img src="<?= getImage($user['image'], 'users'); ?>" width="100px" style="border: solid #00A8A6 1px; border-radius: 3px" alt=""><br>
                    <br><a href="/admin/users" style="font-size:130%">back</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            По вопросам к главному администратору.
          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
