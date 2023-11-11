<footer class="section hero is-light">
  <div class="container">
    <div class="content has-text-centered">
      <div class="tabs">
        <ul>
          <li class="is-active"><a href="/">Главная</a></li>
          <?php foreach (getItems('categories') as $category): ?>
          <li><a href="/category/<?= $category['id'] ?>"><?= $category['title'] ?></a></li>
          <?php endforeach; ?>
          <!-- <li><a>Дизайн и Интерьер</a></li>
          <li><a>Животные</a></li>
          <li><a>Природа</a></li>
          <li><a>Дизайн и Интерьер</a></li>
          <li><a>Животные</a></li>
          <li><a>Природа</a></li>
          <li><a>Дизайн и Интерьер</a></li>
          <li><a>Животные</a></li> -->
        </ul>
      </div>
      <p>
        <strong>Devel</strong> - Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit expedita consequatur, et. Unde, nulla, dicta.
      </p>
      <p class="is-size-7">
        All rights reserved. 2022
      </p>
    </div>
  </div>
</footer>
