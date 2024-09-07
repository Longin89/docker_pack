<?php $this->setSiteTitle('Add a contact'); ?>
<?php $this->start('body'); ?>
<div class="col-md-6 col-md-offset-2 mx-auto p-2 text-bg-secondary">
    <h2 class="text-center">Add a Contact</h2>
    <hr>
    <?php $this->partial('contacts', 'form'); ?>
</div>
<?php $this->end(); ?>