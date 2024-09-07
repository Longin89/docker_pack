  <?php

  use Core\Session;
  ?>
  <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'head.php'); ?>
  <body>
    <div class="wrapper">
      <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'header.php'); ?>
      <main class="main">
      <?= $this->content('body'); ?>
        <section class="main__home">
          <?= Session::displayMsg(); ?>
        </section>
      </main>
      <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'footer.php'); ?>
    </div>
  </body>

  </html>