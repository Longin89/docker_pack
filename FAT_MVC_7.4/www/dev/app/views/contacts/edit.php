<?php $this->setSiteTitle('Edit Contact'); ?>
<?php $this->start('body'); ?>
<div class="col-md-8 col-md-offset-2">
    <h2 class="text-center">Edit <?= $this->contact->displayName(); ?></h2>
    <?php $this->partial('contacts', 'form'); ?>
</div>
<?php $this->end(); ?>