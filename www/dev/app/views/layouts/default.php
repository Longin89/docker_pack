  <?php

  use Core\Session;
  ?>
  <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'partials' . DS . 'head.php'); ?>

  <body>
    <div class="wrapper">
      <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'partials' . DS . 'header.php'); ?>
      <main class="main">
        <?= $this->content('body'); ?>
        <?= Session::displayMsg(); ?>
      </main>
      <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'partials' . DS . 'footer.php'); ?>
    </div>
  </body>

  </html>