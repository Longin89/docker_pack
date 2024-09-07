<?php $this->setSiteTitle($this->contact->displayName()) ?>
<?php $this->start('body') ?>
<div class="col-md-8 col-md-offset-2">
    <a href="<?= PROOT ?>contacts" class="btt btn-xs btn-default">Back</a>
    <h2 class="text-center"><?= $this->contact->displayName(); ?></h2>
    <div class="col-md-6">
        <p><span class="fw-bold">Email: </span><?= $this->contact->email; ?></p>
        <p><span class="fw-bold">Phone Number: </span><?= $this->contact->phone_number; ?></p>
    </div>
    <div class="col-md-6">
        <?= $this->contact->displayAddressLabel(); ?>
    </div>
</div>
<?php $this->end(); ?>