<?php $this->setSiteTitle('Edit Contact'); ?>
<?php $this->start('body'); ?>
<h2 class="title mb-0 mx-auto p-1 text-center">Edit <?= $this->contact->displayName(); ?></h2>
<section class="edit__contacts">
    <div class="contacts__container container">
        <?php $this->partial('contacts', 'form'); ?>
    </div>
</section>
<?php $this->end(); ?>