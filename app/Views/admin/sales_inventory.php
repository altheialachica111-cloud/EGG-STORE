<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Sales Inventory<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-0">Sales Inventory & Reports</h2>
        <p class="text-muted">Track your revenue, best-selling products, and inventory health.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                    <i class="bi bi-currency-exchange text-primary fs-4"></i>
                </div>
                <div>
                    <h6 class="text-uppercase small text-muted mb-0">Total Lifetime Sales</h6>
                    <h3 class="fw-bold mb-0">₱<?= number_format($totalSales, 2) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                    <i class="bi bi-bag-check text-success fs-4"></i>
                </div>
                <div>
                    <h6 class="text-uppercase small text-muted mb-0">Completed Orders</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($totalOrders) ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center">
                <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                    <i class="bi bi-graph-down-arrow text-danger fs-4"></i>
                </div>
                <div>
                    <h6 class="text-uppercase small text-muted mb-0">Total Inventory Loss</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($totalLosses) ?> <small class="fs-6">eggs</small></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Sales by Product -->
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Performance by Egg Type</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Egg Type</th>
                            <th>Quantity Sold (Doz)</th>
                            <th class="text-end pe-4">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($salesByType)): ?>
                            <tr><td colspan="3" class="text-center py-4 text-muted">No sales data available.</td></tr>
                        <?php else: ?>
                            <?php foreach ($salesByType as $sale): ?>
                                <tr>
                                    <td class="ps-4 fw-bold"><?= $sale['name'] ?></td>
                                    <td><?= number_format($sale['total_qty']) ?></td>
                                    <td class="text-end pe-4 fw-bold">₱<?= number_format($sale['total_revenue'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Loss Analytics -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Loss Breakdown</h5>
            </div>
            <div class="card-body">
                <?php if (empty($lossesByReason)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-shield-check fs-1 text-success"></i>
                        <p class="mt-2">No inventory losses recorded.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($lossesByReason as $loss): ?>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold"><?= $loss['reason'] ?></span>
                                <span><?= $loss['total_qty'] ?> eggs</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <?php $pct = ($loss['total_qty'] / $totalLosses) * 100; ?>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $pct ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <hr>
                <div class="alert alert-light border-0 small mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    These figures help you identify breakage patterns and storage efficiency.
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
