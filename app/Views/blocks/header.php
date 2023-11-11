<div class="container">
  <nav class="navbar is-transparent">
    <div class="navbar-brand">
      <a class="navbar-item" href="/">
        <img src="/static/images/bulma-logo.png" width="112" height="28">
      </a>
      <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div id="navbarExampleTransparentExample" class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" href="/">
          Главная
        </a>
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Категории
          </a>
          <div class="navbar-dropdown is-boxed">
            <?php foreach (getItems('categories') as $category): ?>
              <a class="navbar-item" href="/category/<?= $category['id'] ?>">
                <?= $category['title'] ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">

          <div class="field is-grouped">

          <?php if (auth()->isLoggedIn()): ?>
            <p class="control">
              <a class="button is-primary" href="/profile/photos">
                <span class="icon">
                  <i class="fa fa-image"></i>
                </span>
                <span>Мои картинки</span>
              </a>
            </p>

            <p class="control">
              <a class="button is-link" href="/profile/info">
                <span class="icon">
                  <i class="fa fa-user"></i>
                </span>
                <span>Профиль</span>
              </a>
            </p>
            <p class="control">
              <a class="button is-danger" href="/logout">
                <span class="icon">
                  <i class="fa fa-sign-out"></i>
                </span>
                <span>Выйти</span>
              </a>
            </p>
          <?php else: ?>
            <p class="control">
              <a class="button is-link" href="/login">
                <span class="icon">
                  <i class="fa fa-sign-in"></i>
                </span>
                <span>Войти</span>
              </a>
            </p>
            <p class="control">
              <a class="button is-primary" href="/register">
                <span class="icon">
                  <i class="fa fa-sign-in"></i>
                </span>
                <span>Зарегистрироваться</span>
              </a>
            </p>

          <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </nav>
</div>
