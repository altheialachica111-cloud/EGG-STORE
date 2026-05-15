<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Checkout<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Billing & Delivery</h5>
            </div>
            <div class="card-body">
                <form action="/store/process" method="post" id="checkoutForm">
                    <?= csrf_field() ?>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Payment Method</label>
                        <div class="form-check p-3 border rounded mb-2">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="cod" value="Cash on Delivery" checked>
                            <label class="form-check-label d-flex justify-content-between w-100" for="cod">
                                <span>Cash Payment</span>
                                <i class="bi bi-cash-stack text-success"></i>
                            </label>
                        </div>
                        
                        <div id="cashInputContainer" class="mt-3 p-3 bg-light rounded border">
                            <label for="cash_amount" class="form-label small fw-bold">Cash Amount Received (₱)</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" name="cash_amount" id="cash_amount" class="form-control form-control-lg" placeholder="0.00" step="0.01" min="<?= $total ?>" required>
                            </div>
                            <div class="mt-2 small text-muted d-flex justify-content-between">
                                <span>Order Total: ₱<?= number_format($total, 2) ?></span>
                                <span id="changeDisplay" class="fw-bold text-success">Change: ₱0.00</span>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('cash_amount').addEventListener('input', function() {
                            const total = <?= $total ?>;
                            const cash = parseFloat(this.value) || 0;
                            const change = Math.max(0, cash - total);
                            document.getElementById('changeDisplay').textContent = 'Change: ₱' + change.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        });
                    </script>

                    <div class="alert alert-info border-0 bg-light small">
                        <i class="bi bi-info-circle me-2"></i>
                        Your delivery address will be taken from your profile.
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">Place Order (₱<?= number_format($total, 2) ?>)</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Review Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php 
                    $cart = session('cart');
                    $eggTypeModel = new \App\Models\EggTypeModel();
                    foreach ($cart as $id => $qty): 
                        $type = $eggTypeModel->find($id);
                    ?>
                        <div class="list-group-item py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 fw-bold"><?= $type['name'] ?></h6>
                                    <small class="text-muted"><?= $qty ?> dozen x ₱10.00</small>
                                </div>
                                <span class="fw-bold">₱<?= number_format($qty * 10.00, 2) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="p-3 bg-light">
                    <div class="d-flex justify-content-between">
                        <h5 class="fw-bold mb-0">Order Total</h5>
                        <h5 class="fw-bold mb-0 text-primary">₱<?= number_format($total, 2) ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
