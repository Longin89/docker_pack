<?= $this->setSiteTitle('FAT MVC v1.0 - Access restricted'); ?>
<?= $this->start('body'); ?>
<h1 class="title mb-0 mx-auto p-1 text-center" style="border-bottom: 2px solid #324A56;">You don't have permission for this page or page doesn't exist</h1>
<section class="d-flex flex-wrap justify-content-between" style="height: calc(1080px - 40vh); background: url('../images/404.jpg') no-repeat top;
    background-size: contain;">
    <div class="restricted__container container"></div>
</section>
<?= $this->end(); ?>