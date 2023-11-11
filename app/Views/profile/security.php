<?php $this->layout('template') ?>

<div class="container main-content">

  <div class="columns">
      <div class="column">
        <div class="tabs is-centered pt-100">
          <ul>
            <li>
              <a href="/profile/info">
                <span class="icon is-small"><i class="fa fa-user"></i></span>
                <span>Основная информация</span>
              </a>
            </li>
            <li class="is-active">
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
              <?= flash(); ?>
              <form action="" method="post">
                <div class="field">
                  <label class="label">Текущий пароль</label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="password" name="currentPassword">
                    <span class="icon is-small is-left">
                      <i class="fa fa-lock"></i>
                    </span>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Новый пароль</label>
                  <div class="control has-icons-left has-icons-right">
                    <input class="input" type="password" name="newPassword">
                    <span class="icon is-small is-left">
                      <i class="fa fa-lock"></i>
                    </span>
                  </div>
                </div>

                <div class="control">
                  <button class="button is-danger" type="submit">Сменить</button>
                </div>
              </form>
              <br>
            </div>
          </div>
      </div>
  </div>
</div>
