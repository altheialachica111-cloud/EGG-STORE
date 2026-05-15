<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Shop Eggs<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <h2 class="fw-bold mb-0">Storefront</h2>
        <a href="/store/cart" class="btn btn-outline-primary position-relative">
            <i class="bi bi-cart3 fs-5"></i>
            <?php if (session('cart')): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= count(session('cart')) ?>
                </span>
            <?php endif; ?>
        </a>
    </div>

    <?php foreach ($eggTypes as $type): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-bold mb-0"><?= $type['name'] ?></h5>
                        <span class="badge bg-success">₱<?= number_format($type['price'], 2) ?> / doz</span>
                    </div>
                    <p class="text-muted small"><?= $type['description'] ?></p>
                    
                    <div class="mt-3">
                        <p class="mb-2 small">
                            <strong>Stock:</strong> 
                            <?php if ($type['stock'] > 0): ?>
                                <span class="text-success"><?= $type['stock'] ?> eggs available</span>
                            <?php else: ?>
                                <span class="text-danger">Out of Stock</span>
                            <?php endif; ?>
                        </p>
                        
                        <form action="/store/add-to-cart" method="post" class="d-flex">
                            <?= csrf_field() ?>
                            <input type="hidden" name="egg_type_id" value="<?= $type['id'] ?>">
                            <input type="number" name="quantity" class="form-control me-2" value="1" min="1" style="width: 70px;">
                            <button type="submit" class="btn btn-primary w-100" <?= $type['stock'] <= 0 ? 'disabled' : '' ?>>
                                <i class="bi bi-cart-plus me-2"></i>Add
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
