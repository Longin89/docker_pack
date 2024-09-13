<?= $this->setSiteTitle('FAT MVC v1.0 - My Contacts'); ?>
<?php $this->start('body'); ?>
<h2 class="title mb-0 mx-auto p-1 text-center">My Contacts</h2>
<section class="main__contacts">
    <div class="contacts__container container">
        <table class="table table-striped table-condensed table-bordered table-hover">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php foreach ($this->contacts as $contact): ?>
                    <tr>
                        <td>
                            <a href="<?= PROOT ?>contacts/details/<?= $contact->id; ?>" class="nav__username">
                                <?= $contact->displayName(); ?>
                            </a>
                        </td>
                        <td><?= $contact->email; ?></td>
                        <td><?= $contact->phone_number; ?></td>
                        <td>
                            <a href="<?= PROOT ?>contacts/edit/<?= $contact->id; ?>" class="btn btn-info btn-xs">Edit</a>
                            <a href="<?= PROOT ?>contacts/delete/<?= $contact->id; ?>" class="btn btn-danger btn-xs" onclick="if(!confirm('Delete?')){return false;}">Delete</a>
                        </td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php $this->end(); ?>