  <?php

  use Core\Router;
  use Core\H;
  use App\Models\Users;

  $menu = Router::getMenu('menu_acl');
  $currentPage = H::currentPage();
  ?>
  <nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container-fluid">
      <a class="navbar-brand" href="<? ROOT ?>/home"><?= MENU_BRAND ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_menu" aria-controls="main_menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main_menu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center column-gap-4">
          <?php foreach ($menu as $key => $val):
            $active = ''; ?>
            <?php if (is_array($val)): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $key ?></a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php foreach ($val as $k => $v):
                    $active = ($v == $currentPage) ? 'active' : '' ?>
                    <?php if ($k == 'separator'): ?>
                      <li class="dropdown-divider" role="separator"></li>
                    <?php else: ?>
                      <li><a class="<?= $active ?> dropdown-item" href="<?= $v ?>"><?= $k ?></a></li>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              </li>
            <?php else:
              $active = ($val == $currentPage) ? 'active' : '' ?>
              <li><a class="<?= $active ?> dropdown-item" href="<?= $val ?>"><?= $key ?></a></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php if (Users::currentUser()): ?>
            <li><a href="#">Hello <?= Users::currentUser()->fname ?></a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>