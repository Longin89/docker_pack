<?php $this->setSiteTitle('Add a contact'); ?>
<?php $this->start('body'); ?>
<section class="main__addcontact">
    <div class="addcontact__container container">
        <h2 class="title mb-0 mx-auto p-1 text-center">Add a Contact</h2>
        <?php $this->partial('contacts', 'form'); ?>
    </div>
</section>
<?php $this->end(); ?>