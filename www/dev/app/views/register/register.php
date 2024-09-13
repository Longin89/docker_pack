<?php

use Core\FH;
?>

<?= $this->setSiteTitle('FAT MVC v1.0 - Register'); ?>
<?php $this->start('body'); ?>
<section class="main__register login">
    <div class="register__container container">
        <form class="d-flex flex-column align-items-center rounded-4 border border-primary-subtle bg-light bg-gradient my-4 mx-auto" style="width: 70%; min-width: 315px;" action="" method="post">
            <?= FH::csrfInput(); ?>
            <?= FH::displayErrors($this->displayErrors) ?>
            <h2 class="title mb-0 mx-auto p-1 text-center">Register</h2>
            <ul class="p-0">
                <li class="register__form-item justify-content-start">
                    <?= FH::inputBlock('text', 'First Name', 'fname', $this->newUser->fname, ['class' => 'form-control input-sm'], ['class' => 'justify-content-start']); ?>
                </li>
                <li class="register__form-item justify-content-start">
                    <?= FH::inputBlock('text', 'Last Name', 'lname', $this->newUser->lname, ['class' => 'form-control input-sm'], ['class' => 'justify-content-start']); ?>
                </li>
                <li class="register__form-item justify-content-start">
                    <?= FH::inputBlock('text', 'Email', 'email', $this->newUser->email, ['class' => 'form-control input-sm'], ['class' => 'justify-content-start']); ?>
                </li>
                <li class="register__form-item justify-content-start">
                    <?= FH::inputBlock('text', 'Username', 'username', $this->newUser->username, ['class' => 'form-control input-sm'], ['class' => 'justify-content-start']); ?>
                </li>
                <li class="register__form-item justify-content-start">
                    <?= FH::inputBlock('password', 'Password', 'password', $this->newUser->password, ['class' => 'form-control input-sm'], ['class' => 'justify-content-start']); ?>
                </li>
                <li class="register__form-item justify-content-start">
                    <?= FH::inputBlock('password', 'Confirm Password', 'confirm', $this->newUser->getConfirm(), ['class' => 'form-control input-sm'], ['class' => 'justify-content-start']); ?>
                </li>
                <li class="m-0 p-1 text-center">
                    <?= FH::submitBlock('Register', ['class' => 'btn btn-primary btn-large'], ['class' => 'text-right']); ?>
                </li>
            </ul>
        </form>
    </div>
</section>
<?php $this->end(); ?>