<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Order Management<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 fw-bold">Order Management</h2>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-3">
                <form action="/admin/orders" method="get" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Order Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="Pending" <?= ($filters['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                            <option value="Approved" <?= ($filters['status'] == 'Approved') ? 'selected' : '' ?>>Approved</option>
                            <option value="Out for Delivery" <?= ($filters['status'] == 'Out for Delivery') ? 'selected' : '' ?>>Out for Delivery</option>
                            <option value="Completed" <?= ($filters['status'] == 'Completed') ? 'selected' : '' ?>>Completed</option>
                            <option value="Cancelled" <?= ($filters['status'] == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Payment Status</label>
                        <select name="payment_status" class="form-select form-select-sm">
                            <option value="">All Payments</option>
                            <option value="Unpaid" <?= ($filters['payment_status'] == 'Unpaid') ? 'selected' : '' ?>>Unpaid</option>
                            <option value="Paid" <?= ($filters['payment_status'] == 'Paid') ? 'selected' : '' ?>>Paid</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Date</label>
                        <input type="date" name="date" class="form-select form-select-sm" value="<?= $filters['date'] ?>">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm flex-grow-1">Filter</button>
                        <a href="/admin/orders" class="btn btn-outline-secondary btn-sm flex-grow-1">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Customer Orders</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Order ID</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Method</th>
                            <th>Payment</th>
                            <th>Order Status</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr><td colspan="8" class="text-center py-5 text-muted">No orders found matching filters.</td></tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td class="ps-4 fw-bold">#<?= $order['id'] ?></td>
                                    <td><?= esc($order['username']) ?></td>
                                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td><small class="text-muted"><?= $order['payment_method'] ?></small></td>
                                    <td>
                                        <span class="badge <?= ($order['payment_status'] == 'Paid') ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $order['payment_status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php 
                                            $badgeClass = 'bg-secondary';
                                            if ($order['status'] == 'Picking') $badgeClass = 'bg-info';
                                            if ($order['status'] == 'Packing') $badgeClass = 'bg-primary';
                                            if ($order['status'] == 'Out for Delivery') $badgeClass = 'bg-warning text-dark';
                                            if ($order['status'] == 'Completed') $badgeClass = 'bg-success';
                                            if ($order['status'] == 'Cancelled') $badgeClass = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $order['status'] ?></span>
                                        <?php if ($order['quality_checked']): ?>
                                            <i class="bi bi-check-circle-fill text-success ms-1" title="Quality Checked"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Update
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                <li class="dropdown-header small fw-bold">Order Lifecycle</li>
                                                <li>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Picking">
                                                        <button type="submit" class="dropdown-item py-1">Start Picking (FIFO)</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Packing">
                                                        <button type="submit" class="dropdown-item py-1">Mark as Packed (QC Pass)</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item py-1" data-bs-toggle="modal" data-bs-target="#deliveryModal<?= $order['id'] ?>">
                                                        Assign Delivery
                                                    </button>
                                                </li>
                                                <li>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Completed">
                                                        <button type="submit" class="dropdown-item py-1 text-success">Confirm Completion</button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li class="dropdown-header small fw-bold text-danger">Actions</li>
                                                <li>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Cancelled">
                                                        <button type="submit" class="dropdown-item py-1 text-danger">Cancel Order</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Delivery Assignment Modal -->
                                        <div class="modal fade" id="deliveryModal<?= $order['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-start">Assign Rider: Order #<?= $order['id'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Out for Delivery">
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label">Rider Name</label>
                                                                <input type="text" name="rider_name" class="form-control" placeholder="e.g. John Doe" required>
                                                            </div>
                                                            <div class="alert alert-info py-2 small">
                                                                <i class="bi bi-info-circle me-2"></i>
                                                                This will generate a tracking link and simulate an SMS notification to the customer.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-warning btn-sm fw-bold">Dispatch Order</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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

