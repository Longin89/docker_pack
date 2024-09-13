<?php

use Core\FH;
?>

<?= $this->setSiteTitle('FAT MVC v1.0 - Login'); ?>
<?php $this->start('body'); ?>
<section class="main__register login">
    <div class="login__container container">
        <form class="d-flex flex-column align-items-center rounded-4 border border-primary-subtle bg-light bg-gradient my-4 mx-auto" style="width: 70%; min-width: 315px;" action="<?= PROOT ?>register/login" method="post">
            <?= FH::csrfInput(); ?>
            <?= FH::displayErrors($this->displayErrors); ?>
            <h2 class="title mb-0 mx-auto p-1 text-center">Login</h2>
            <ul class="m-0 p-1">
                <li class="register__form-item d-flex align-items-center justify-content-start">
                    <?= FH::inputBlock('text', 'Username', 'username', $this->login->username, ['class' => 'form-control'], ['class' => 'justify-content-center']); ?>
                </li>
                <li class="register__form-item d-flex align-items-center justify-content-start">
                    <?= FH::inputBlock('password', 'Password', 'password', $this->login->password, ['class' => 'form-control'], ['class' => 'justify-content-center']); ?>
                </li>
                <li class="register__form-item d-flex align-items-center justify-content-end">
                    <?= FH::checkboxBlock('Remember Me', 'remember_me', $this->login->getRememberMeChecked(), [], ['class' => 'justify-content-center']); ?>
                </li>
                <li class="register__form-item d-flex align-items-center justify-content-center">
                    <?= FH::submitBlock('Login', ['class' => 'btn btn-large btn-primary'], ['class' => 'justify-content-center']); ?>
                </li>
                <li class="register__form-item d-flex align-items-center justify-content-end">
                    <a href="<?= PROOT ?>register/register" class="register__item-link">Register</a>
                </li>
            </ul>
        </form>
    </div>
</section>
<?php $this->end(); ?>