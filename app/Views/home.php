<?php $this->layout('template') ?>

<section class="hero is-medium is-primary is-bold">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
        Самые минималистичные и элегантные обои для вашего рабочего стола!
      </h1>
      <h2 class="subtitle">
        Настроение и вдохновение в одном кадре.
      </h2>
    </div>
  </div>
</section>
<section class="section main-content">
  <div class="container">
    <div class="columns  is-multiline">

      <?php foreach ($photos as $photo): ?>
      <div class="column is-one-quarter">
        <div class="card">
          <div class="card-image">
            <figure class="image is-4by3">
              <a href="/photo/<?= $photo['id']; ?>">
                <img src="<?= getImage($photo['image'], 'photos'); ?>" class="image-bor" alt="Placeholder image">
              </a>
            </figure>
          </div>
          <div class="card-content">
            <p class="title is-5"><a href="/category/<?= getItem('categories', $photo['category_id'])['id']; ?>"><?= getItem('categories', $photo['category_id'])['title']; ?></a></p>
            <p class="title is-5 is-size-6"><?= $photo['title']; ?></p>
            <div class="content-block">
              <div>
                <p class="title is-size-6">u: <a href="/user/<?= getItem('users', $photo['user_id'])['id']; ?>"><?= getItem('users', $photo['user_id'])['username']; ?></a></p>
              </div>
              <div>
                <p class="is-size-7">Размер: <?= getFileSize(config('uploadFolder').$photo['image']); ?></p>
                <p class="is-size-7">Разрешение: <?= $photo['dimensions']; ?></p>
                <time datetime="2016-1-1" class="is-size-7">Добавлено: <?= uploadedDate($photo['date']); ?></time>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
    <?= paginator($paginator); ?>
  </div>
</section>
