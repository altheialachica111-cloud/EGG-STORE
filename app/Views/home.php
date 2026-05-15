<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <!-- Existing Stats Cards -->
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
                <h2 class="fw-bold mb-0">₱<?= number_format($monthlyRevenue, 2) ?></h2>
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
    <!-- Low Stock Alerts -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-octagon me-2"></i>Low Stock Alerts</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($lowStockItems)): ?>
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-check2-circle fs-1 text-success"></i>
                        <p class="mt-2">All stock levels are healthy.</p>
                    </div>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($lowStockItems as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <h6 class="mb-0 fw-bold"><?= $item['name'] ?></h6>
                                    <small class="text-muted">Threshold: <?= $item['low_stock_threshold'] ?> eggs</small>
                                </div>
                                <span class="badge bg-danger rounded-pill"><?= (int)$item['current_stock'] ?> eggs</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Recent Activity</h5>
                <a href="/admin/orders" class="btn btn-sm btn-link text-decoration-none">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="pe-4">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentOrders)): ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">No recent activity.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td class="ps-4 fw-bold">#<?= $order['id'] ?></td>
                                    <td><?= $order['username'] ?></td>
                                    <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                    <td>
                                        <?php 
                                            $badgeClass = match($order['status']) {
                                                'Pending' => 'bg-warning text-dark',
                                                'Completed' => 'bg-success',
                                                'Cancelled' => 'bg-danger',
                                                default => 'bg-primary'
                                            };
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $order['status'] ?></span>
                                    </td>
                                    <td class="pe-4 small"><?= date('M d, H:i', strtotime($order['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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
