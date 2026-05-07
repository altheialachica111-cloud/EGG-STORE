<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <h6 class="text-uppercase small">Total Dozens in Stock</h6>
                <h2 class="fw-bold mb-0"><?= number_format($totalDozens) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body">
                <h6 class="text-uppercase small">Orders Pending Today</h6>
                <h2 class="fw-bold mb-0"><?= number_format($pendingOrders) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <h6 class="text-uppercase small">Revenue (This Month)</h6>
                <h2 class="fw-bold mb-0">$<?= number_format($monthlyRevenue, 2) ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-danger text-white">
            <div class="card-body">
                <h6 class="text-uppercase small">Expiring (48h)</h6>
                <h2 class="fw-bold mb-0"><?= number_format($expiryAlerts) ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
            <div class="container-fluid py-5 text-center">
                <h1 class="display-5 fw-bold text-dark">Welcome to Egg Store</h1>
                <p class="fs-4 text-muted">Your premium destination for the freshest eggs.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-plus-circle text-success fs-4"></i>
                    </div>
                    <h5 class="card-title mb-0">Stock Intake</h5>
                </div>
                <p class="card-text text-muted">Log incoming batches from suppliers with laid dates and batch IDs.</p>
                <a href="/admin/stock-intake" class="btn btn-success w-100">Log New Batch</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-graph-up text-primary fs-4"></i>
                    </div>
                    <h5 class="card-title mb-0">Inventory</h5>
                </div>
                <p class="card-text text-muted">Review stock levels and get alerts for low stock or near-expiry dates.</p>
                <a href="/admin/inventory" class="btn btn-primary w-100">View Stock</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-people text-info fs-4"></i>
                    </div>
                    <h5 class="card-title mb-0">Users</h5>
                </div>
                <p class="card-text text-muted">Manage system users, administrators, and permissions.</p>
                <a href="/admin/users" class="btn btn-info text-white w-100">Manage Users</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
