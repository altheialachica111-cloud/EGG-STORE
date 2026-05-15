<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Your Cart<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Shopping Cart</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($items)): ?>
                    <div class="p-5 text-center">
                        <i class="bi bi-cart-x fs-1 text-muted"></i>
                        <p class="mt-3 text-muted">Your cart is empty.</p>
                        <a href="/store" class="btn btn-primary">Go Shopping</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <h6 class="mb-0 fw-bold"><?= $item['name'] ?></h6>
                                        </td>
                                        <td>₱<?= number_format($item['price'], 2) ?></td>
                                        <td><?= $item['qty'] ?> doz</td>
                                        <td>₱<?= number_format($item['subtotal'], 2) ?></td>
                                        <td class="text-end pe-4">
                                            <a href="#" class="text-danger"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <a href="/store" class="btn btn-link text-decoration-none px-0">
            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
        </a>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>₱<?= number_format($total, 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Delivery</span>
                    <span class="text-success">FREE</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <h5 class="fw-bold">Total</h5>
                    <h5 class="fw-bold">₱<?= number_format($total, 2) ?></h5>
                </div>
                
                <a href="/store/checkout" class="btn btn-primary w-100 btn-lg <?= empty($items) ? 'disabled' : '' ?>">
                    Proceed to Checkout
                </a>
                
                <form action="/store/clear-cart" method="post" class="mt-3">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">Clear Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
