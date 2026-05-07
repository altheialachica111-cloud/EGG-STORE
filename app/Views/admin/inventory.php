<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Inventory Monitoring<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold">Inventory Monitoring</h2>
            <a href="/admin/stock-intake" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Add Stock</a>
        </div>

        <?php if (!empty($nearExpiry)): ?>
            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>Expiry Alert:</strong> You have <?= count($nearExpiry) ?> batch(es) nearing expiration!
                </div>
            </div>
        <?php endif ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Current Stock Batches</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Batch ID</th>
                            <th>Egg Type</th>
                            <th>Quantity (Rem/Total)</th>
                            <th>Laid Date</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($batches)): ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">No stock logged yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($batches as $batch): ?>
                                <?php 
                                    $isNearExpiry = (strtotime($batch['expiry_date']) <= strtotime('+3 days'));
                                    $isExpired = (strtotime($batch['expiry_date']) < time());
                                ?>
                                <tr class="<?= $isExpired ? 'table-danger' : ($isNearExpiry ? 'table-warning' : '') ?>">
                                    <td class="ps-4 fw-bold"><?= $batch['batch_id'] ?></td>
                                    <td><?= $batch['egg_name'] ?></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span><?= $batch['quantity_remaining'] ?> / <?= $batch['quantity_added'] ?></span>
                                            <div class="progress mt-1" style="height: 5px;">
                                                <?php $pct = ($batch['quantity_remaining'] / $batch['quantity_added']) * 100; ?>
                                                <div class="progress-bar" role="progressbar" style="width: <?= $pct ?>%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $batch['laid_date'] ?></td>
                                    <td><?= $batch['expiry_date'] ?></td>
                                    <td>
                                        <?php if ($isExpired): ?>
                                            <span class="badge bg-danger">Expired</span>
                                        <?php elseif ($isNearExpiry): ?>
                                            <span class="badge bg-warning text-dark">Near Expiry</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Fresh</span>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
