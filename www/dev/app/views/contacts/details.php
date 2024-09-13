<?php $this->setSiteTitle('FAT MVC v1.0 - Edit ' . $this->contact->displayName()) ?>
<?php $this->start('body') ?>
<h2 class="title mb-0 mx-auto p-1 text-center"><?= $this->contact->displayName(); ?></h2>
<section class="main__details">
    <div class="details__container container">
        <ul class="text-center my-4 mx-auto p-0">
            <li class="main__list-item">
                <p><span class="main__item-desc">Name: </span><?= $this->contact->displayName(); ?></p>
            </li>
            <li class="main__list-item">
                <p><span class="main__item-desc">Email: </span><?= $this->contact->email; ?></p>
            </li>
            <li class="main__list-item">
                <p><span class="main__item-desc">City: </span><?= $this->contact->city; ?></p>
            </li>
            <li class="main__list-item">
                <p><span class="main__item-desc">Address: </span><?= $this->contact->address; ?></p>
            </li>
            <li class="main__list-item">
                <p><span class="main__item-desc">Zipcode: </span><?= $this->contact->zipcode; ?></p>
            </li>
            <li class="main__list-item">
                <p><span class="main__item-desc">Phone Number: </span><?= $this->contact->phone_number; ?></p>
            </li>
            <li class="main__list-item">
                <a href="<?= PROOT ?>contacts" class="btt btn-xs btn-default back__button">Back</a>
            </li>
        </ul>
    </div>
</section>
<?php $this->end(); ?>