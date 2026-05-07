<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Stock Intake<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Log Incoming Stock Batch</h5>
            </div>
            <div class="card-body p-4">
                <?php if (session('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="/admin/add-stock" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Batch ID (Supplier)</label>
                            <input type="text" name="batch_id" class="form-control" placeholder="e.g. BATCH-2024-001" value="<?= old('batch_id') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Egg Type</label>
                            <select name="egg_type_id" class="form-select" required>
                                <?php foreach ($eggTypes as $type): ?>
                                    <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                                <?php endforeach ?>
                                <?php if (empty($eggTypes)): ?>
                                    <option disabled>Please seed database first</option>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Quantity (Eggs)</label>
                            <input type="number" name="quantity" class="form-control" placeholder="360" value="<?= old('quantity') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Laid Date</label>
                            <input type="date" name="laid_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Supplier Name</label>
                        <input type="text" name="supplier_name" class="form-control" placeholder="Happy Farm Co." value="<?= old('supplier_name') ?>">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">Log Stock Intake</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
