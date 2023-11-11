<?php $this->layout('template'); ?>
<div class="container main-content">

  <div class="columns">
      <div class="column">
        <div class="tabs is-centered pt-100">
          <ul>
            <li class="is-active">
              <a href="/profile/info">
                <span class="icon is-small"><i class="fa fa-user"></i></span>
                <span>Основная информация</span>
              </a>
            </li>
            <li>
              <a href="/profile/security">
                <span class="icon is-small"><i class="fa fa-lock"></i></span>
                <span>Безопасность</span>
              </a>
            </li>
          </ul>

        </div>
        <div class="is-clearfix"></div>
          <div class="columns is-centered">
            <div class="column is-half">
              <form action="" method="post" enctype="multipart/form-data">
                <div class="field">
                  <label class="label">Ваше имя</label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="text" name="username" value="<?= $info['username'] ?>">
                    <span class="icon is-small is-left">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Email</label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="email" name="email" value="<?= $info['email'] ?>">
                    <span class="icon is-small is-left">
                      <i class="fa fa-envelope"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Аватар <a href="/profile/info/default_avatar/<?= $info['id']; ?>" onclick="return confirm('Вы уверены, что хотите сбросить аватар?')">по умолчанию</a>
                  </label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="file" name="image">
                    <span class="icon is-small is-left">
                      <i class="fa fa-image"></i>
                    </span>
                  </div>
                </div>

                <?= flash(); ?>
                <div class="control">
                  <button class="button is-link" type="submit">Обновить</button>
                  <!-- <button class="button is-warning" type="reset">Очистить</button> -->
                </div>
              </form>
            </div>
            <img src="<?= getImage($info['image'], 'users'); ?>" class="user-avatar" alt="">
          </div>
          <br>
      </div>
  </div>
</div>
