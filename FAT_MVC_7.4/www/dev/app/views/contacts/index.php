<?php $this->start('body'); ?>
<h2 class="text-center">My Contacts</h2>
<table class="table tavle-striped table-condensed table-bordered table-hover">
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
    </thead>
    <tbody>
        <?php foreach ($this->contacts as $contact): ?>
            <tr>
                <td>
                    <a href="<?= PROOT ?>contacts/details/<?= $contact->id; ?>">
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
<?php $this->end(); ?>