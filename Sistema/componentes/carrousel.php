<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php for ($i = 0; $i < $resultCarousel->num_rows; $i++): ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>" aria-current="<?= $i === 0 ? 'true' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
        <?php endfor; ?>
    </div>
    <div class="carousel-inner">
        <?php $i = 0; while ($slide = $resultCarousel->fetch_assoc()): ?>
            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                <img src="areaSegura/admin/<?= $slide['image_path'] ?>" class="d-block w-100" alt="<?= $slide['title'] ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class=""><b><?= $slide['title'] ?></h1></b>
                    <p class="fs-4"><?= $slide['description'] ?></p>
                </div>
            </div>
            <?php $i++; endwhile; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>