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
            <div class="">
            <div class="box-header">
              <h2 class="box-title">Изменить пользователя</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                  <?= flash(); ?>
                    <form action="" method="post">
                      <div class="form-group">
                        <label for="email">Email</label> <i><small>(Внимание! Если измените эл. почту пользователя, то сообщите ему)</small></i>
                        <input type="email" class="form-control" id="email" value="<?= $user['email']; ?>" name="email">
                      </div>

                      <div class="form-group">
                        <label for="first_name">Имя</label> <i><small>(Обязательно)</small></i>
                        <input type="text" class="form-control" id="first_name" value="<?= $user['username']; ?>" name="first_name">
                      </div>

                      <div class="form-group">
                        <label>Роль</label>  <i><small>(Выбор прав для пользователя)</small></i>
                        <select class="form-control select2" style="width: 100%;" name="roles_mask">
                          <?php foreach ($roles as $role): ?>
                            <option <?php if($role['id'] == $user['roles_mask']): ?>selected <?php endif; ?> value="<?= $role['id']; ?>"><?= $role['title']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="image">Аватар</label>
                        <input type="file" id="image" name="image">
                        <br>
                        <img src="<?= getImage($user['image'], 'users') ?>" width="200" alt="">
                      </div>

                      <div class="form-group">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="status" <?php if($user['status']): ?>checked <?php endif; ?>>
                            Бан
                          </label>
                        </div> <i><small>(Статус пользователя)</small></i>
                      </div>

                      <div class="form-group">
                        <button class="btn btn-warning" type="submit">Изменить</button>
                      </div>
                    </form>
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
