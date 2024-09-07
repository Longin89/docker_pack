<?php

use Core\FH;
?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
        <section class="register">
            <div class="register__container container">
                <form class="register__form" action="" method="post">
                    <?= FH::csrfInput(); ?>
                    <?= FH::displayErrors($this->displayErrors) ?>
                    <h2 class="register__title default__title">Register</h2>
                    <ul class="register__form-list">
                        <li class="register__form-item form-group">
                            <?= FH::inputBlock('text', 'First Name', 'fname', $this->newUser->fname, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
                        </li>
                        <li class="register__form-item form-group">
                            <?= FH::inputBlock('text', 'Last Name', 'lname', $this->newUser->lname, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
                        </li>
                        <li class="register__form-item form-group">
                            <?= FH::inputBlock('text', 'Email', 'email', $this->newUser->email, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
                        </li>
                        <li class="register__form-item form-group">
                            <?= FH::inputBlock('text', 'Username', 'username', $this->newUser->username, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
                        </li>
                        <li class="register__form-item form-group">
                            <?= FH::inputBlock('password', 'Password', 'password', $this->newUser->password, ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
                        </li>
                        <li class="register__form-item form-group">
                            <?= FH::inputBlock('password', 'Confirm Password', 'confirm', $this->newUser->getConfirm(), ['class' => 'form-control input-sm'], ['class' => 'form-group']); ?>
                        </li>
                        <li class="register__form-item form-group">
                            <?= FH::submitBlock('Register', ['class' => 'btn btn-primary btn-large'], ['class' => 'text-right']); ?>
                        </li>
                    </ul>
                </form>
            </div>
        </section>