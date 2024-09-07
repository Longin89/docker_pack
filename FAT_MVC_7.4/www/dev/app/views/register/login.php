<?php

use Core\FH;
?>

<?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'head.php'); ?>
    <body>
        <div class="wrapper">
        <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'header.php'); ?>
        <main class="main">
        <?php $this->start('body'); ?>
        <?php $this->end(); ?>
            <section class="register">
                <div class="register__container container">
                    <h2 class="register__title default__title">Login</h2>
                    <form class="register__form" action="<?= PROOT ?>register/login" method="post">
                        <?= FH::csrfInput(); ?>
                        <?= FH::displayErrors($this->displayErrors); ?>
                        <ul class="register__form-list">
                            <li class="register__form-item form-group">
                                <?= FH::inputBlock('text', 'Username', 'username', $this->login->username, ['class' => 'form-control'], ['class' => 'form-group']); ?>
                            </li>
                            <li class="register__form-item form-group">
                                <?= FH::inputBlock('password', 'Password', 'password', $this->login->password, ['class' => 'form-control'], ['class' => 'form-group']); ?>
                            </li>
                            <li class="register__form-item form-group">
                                <?= FH::checkboxBlock('Remember Me', 'remember_me', $this->login->getRememberMeChecked(), [], ['class' => 'form-group']); ?>
                            </li>
                            <li class="register__form-item form-group">
                                <?= FH::submitBlock('Login', ['class' => 'btn btn-large btn-primary'], ['class' => 'form-group']); ?>
                            </li>
                            <li class="register__form-item form-group">
                                <a href="<?= PROOT ?>register/register" class="register__item-link">Register</a>
                            </li>
                        </ul>
                    </form>
                </div>
            </section>
        </main>
        <?php require_once(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . 'footer.php'); ?>
        </div>
    </body>
