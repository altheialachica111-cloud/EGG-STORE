<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Order Management<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <h2 class="mb-4 fw-bold">Order Management</h2>

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
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">No orders found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td class="ps-4 fw-bold">#<?= $order['id'] ?></td>
                                    <td><?= esc($order['username']) ?></td>
                                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td>
                                        <?php 
                                            $badgeClass = 'bg-secondary';
                                            if ($order['status'] == 'Approved') $badgeClass = 'bg-info';
                                            if ($order['status'] == 'Out for Delivery') $badgeClass = 'bg-warning text-dark';
                                            if ($order['status'] == 'Completed') $badgeClass = 'bg-success';
                                            if ($order['status'] == 'Cancelled') $badgeClass = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $order['status'] ?></span>
                                    </td>
                                    <td><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Update Status
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Approved">
                                                        <button type="submit" class="dropdown-item">Approve Order</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Out for Delivery">
                                                        <button type="submit" class="dropdown-item">Mark as Dispatched</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Completed">
                                                        <button type="submit" class="dropdown-item text-success">Mark as Completed</button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="/admin/update-order-status" method="post">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                        <input type="hidden" name="status" value="Cancelled">
                                                        <button type="submit" class="dropdown-item text-danger">Cancel Order</button>
                                                    </form>
                                                </li>
                                            </ul>
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
