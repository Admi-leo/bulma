<?php $this->layout('template'); ?>
<section class="hero is-primary">
  <div class="hero-body">
    <div class="container">

      <h1 class="title">
        Моя галерея
      </h1>
      <h2 class="subtitle">
        Загруженные вами картинки
      </h2>

      <p class="control">
        <a class="button is-danger" href="/profile/upload/photo">
          <span class="icon">
            <i class="fa fa-upload"></i>
          </span>
          <span>Загрузить картинку</span>
        </a>
      </p>
      <span><?= flash(); ?></span>

    </div>
  </div>
</section>
<section class="section main-content">
  <div class="container">
    <div class="columns is-multiline">
      <?php foreach ($photos as $photo): ?>
      <div class="column is-one-quarter">
        <div class="card">
          <div class="card-image">
            <figure class="image is-4by3">
              <a href="/photo/<?= $photo['id']; ?>">
                <br>
                <img src="<?= getImage($photo['image'], 'photos'); ?>" class="image-bor" alt="Placeholder image">
              </a>
            </figure>
          </div>
          <div class="card-content">
            <div class="my-photo">
              <label class="title is-4"><?= $photo['title'] ?></label>
              <p class="is-5"><?= $photo['description'] ?></p><br>
              <div class="content-block">
                  <div class="mr-2">
                    <p class="title is-5">
                      <a href="/profile/photo/update/<?= $photo['id']; ?>" class="button btn-sm is-warning">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="/profile/photo/delete/<?= $photo['id']; ?>" class="button btn-sm is-danger" onclick="return confirm('Вы уверены, что хотите удалить картинку')">
                        <i class="fa fa-remove"></i>
                      </a>
                    </p>
                  </div>
                  <div>
                    <li>Размер: <?= getFileSize(config('uploadFolder').$photo['image']); ?></li>
                    <li>Разрешение: <?= $photo['dimensions'] ?></li>
                    <li>Добавлено: <?= uploadedDate($photo['date']); ?></li>
                  </div>
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
