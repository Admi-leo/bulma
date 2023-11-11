<?php $this->layout('template'); ?>
<section class="hero is-info is-medium">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        <?= $photo['title'] ?>
      </h1>
      <h2 class="subtitle">
        <?= $photo['description'] ?>
      </h2>
    </div>
  </div>
</section>

<div class="container main-content">
  <div class="columns">
    <div class="column"></div>
    <div class="column is-half auth-form">
      <div class="card">
        <div class="card-image">
          <figure class="image is-4by3">
            <img src="<?= getImage($photo['image'], 'photos'); ?>" class="image-bor" alt="Placeholder image">
          </figure>
        </div>
        <div class="card-content">
          <div class="media">
            <div class="media-left">
              <figure class="image is-48x48">
                <img src="<?= getImage($user['image'], 'users'); ?>" class="image-bor" alt="Placeholder image">
              </figure>
            </div>
              <p class="title is-4">
                Добавил: <a href="/user/<?= $user['id'] ?>"><?= $user['username']; ?></a>
              </p>
          </div>

          <div class="content">
            <?= $photo['description']; ?>
            <br>
            <span class="is-size-7">Размер: <?= getFileSize(config('uploadFolder').$photo['image']); ?></span><br>
            <span class="is-size-7">Разрешение: <?= $photo['dimensions']; ?></span><br>
            <time datetime="2016-1-1" class="is-size-7">Добавлено: <?= uploadedDate($photo['date']); ?></time>
            <a href="/photo/download/<?= $photo['id']; ?>" class="button is-info is-pulled-right">Скачать</a>
            <div class="is-clearfix"></div>
          </div>
        </div>
      </div>

    </div>
    <div class="column"></div>
  </div>

  <hr>

  <div class="columns">
    <div class="column">
      <h1 class="title">Другие фотографии от <a href="/user/<?= $user['id'] ?>"><?= $user['username'] ?></a></h1>
    </div>
  </div>

  <div class="columns section">

    <?php foreach ($userImages as $userPhoto): ?>
      <div class="column is-one-quarter">
        <div class="card">
          <div class="card-image">
            <figure class="image is-4by3">
              <a href="/photo/<?= $userPhoto['id']; ?>">
                <img src="<?= getImage($userPhoto['image'], 'photos'); ?>" class="image-bor" alt="Placeholder image">
              </a>
            </figure>
          </div>
          <div class="card-content">
            <p class="title is-5"><a href="/category/<?= getItem('categories', $photo['category_id'])['id']; ?>"><?= getItem('categories', $photo['category_id'])['title']; ?></a></p>
            <div>
              <p class="title is-5 is-size-6"><?= $userPhoto['title']; ?></p>
            </div>
            <div class="content-block">
              <p class="is-size-7">Размер: <?= getFileSize(config('uploadFolder').$photo['image']); ?></p>
              <p class="is-size-7">Разрешение: <?= $photo['dimensions']; ?></p>
              <time datetime="2016-1-1" class="is-size-7">Добавлено: <?= uploadedDate($photo['date']); ?></time>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</div>
