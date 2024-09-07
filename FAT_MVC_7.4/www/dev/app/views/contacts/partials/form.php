<?php

use Core\FH;
?>
<form class="form d-flex flex-wrap" action="<?= $this->postAction ?>" method="post">
    <?= FH::displayErrors($this->displayErrors); ?>
    <?= FH::csrfInput(); ?>
    <?= FH::inputBlock('text', 'First Name', 'fname', $this->contact->fname, ['class' => 'form-control'], ['class' => 'form-group col-md-6 p-2']); ?>
    <?= FH::inputBlock('text', 'Last Name', 'lname', $this->contact->lname, ['class' => 'form-control'], ['class' => 'form-group col-md-6 p-2']); ?>
    <?= FH::inputBlock('text', 'City', 'city', $this->contact->city, ['class' => 'form-control'], ['class' => 'form-group col-md-6 p-2']); ?>
    <?= FH::inputBlock('text', 'Address', 'address', $this->contact->address, ['class' => 'form-control'], ['class' => 'form-group col-md-6 p-2']); ?>
    <?= FH::inputBlock('text', 'Zipcode', 'zipcode', $this->contact->zipcode, ['class' => 'form-control'], ['class' => 'form-group col-md-4 p-2']); ?>
    <?= FH::inputBlock('text', 'Email', 'email', $this->contact->email, ['class' => 'form-control'], ['class' => 'form-group col-md-4 p-2']); ?>
    <?= FH::inputBlock('text', 'Phone Number', 'phone_number', $this->contact->phone_number, ['class' => 'form-control'], ['class' => 'form-group col-md-4 p-2']); ?>
    <div class="text-right p-2" style="margin-left: auto;">
        <a href="<?= PROOT ?>contacts" class="btn btn-default">Cancel</a>
        <?= FH::submitTag('Save', ['class' => 'btn btn-primary']); ?>
    </div>
</form>