<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Order Success<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center py-4">
    <div class="col-md-6 text-center">
        <div class="mb-4">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
        </div>
        <h1 class="fw-bold mb-3">Order Placed!</h1>

        <?php if ($receipt = session('receipt')): ?>
            <!-- Main Receipt -->
            <div class="d-flex justify-content-center mb-5">
                <div class="card shadow-lg border-0" style="max-width: 400px; width: 100%; font-family: 'Courier New', Courier, monospace; background-color: #fffbe6;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold mb-0">🥚 EGG STORE</h4>
                            <small class="text-muted">Official Receipt</small>
                            <div class="mt-2 small">
                                Date: <?= date('M d, Y H:i') ?><br>
                                Order ID: #<?= $receipt['order_id'] ?>
                            </div>
                        </div>
                        
                        <hr style="border-top: 2px dashed #888;">
                        
                        <div class="mb-3">
                            <?php 
                            $eggTypeModel = new \App\Models\EggTypeModel();
                            $totalItems = 0;
                            foreach ($receipt['items'] as $id => $qty): 
                                $type = $eggTypeModel->find($id);
                                $totalItems += $qty;
                            ?>
                                <div class="d-flex justify-content-between mb-1">
                                    <span><?= $qty ?> x <?= $type['name'] ?></span>
                                    <span>₱<?= number_format($qty * 10.00, 2) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Total Items (Dozens):</span>
                            <span><?= $totalItems ?></span>
                        </div>

                        <hr style="border-top: 2px dashed #888;">
                        
                        <div class="d-flex justify-content-between fw-bold mb-1 fs-5">
                            <span>TOTAL</span>
                            <span>₱<?= number_format($receipt['total'], 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>CASH RECEIVED</span>
                            <span>₱<?= number_format($receipt['cash'], 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold text-success fs-5">
                            <span>CHANGE</span>
                            <span>₱<?= number_format($receipt['change'], 2) ?></span>
                        </div>
                        
                        <div class="text-center mt-5 small">
                            <p class="mb-0">Thank you for your purchase!</p>
                            <p class="mb-0 fw-bold">Visit us again soon!</p>
                        </div>
                        
                        <div class="text-center mt-4 no-print">
                            <button onclick="window.print()" class="btn btn-dark w-100">
                                <i class="bi bi-printer me-2"></i>Print Receipt
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <style>
                @media print {
                    .no-print, .sidebar, .navbar, .btn, .alert, .h1, .bi-check-circle-fill, .d-grid { display: none !important; }
                    .main-content { margin: 0 !important; padding: 0 !important; width: 100% !important; }
                    .card { box-shadow: none !important; border: none !important; margin: 0 auto !important; }
                    body { background: white !important; }
                }
            </style>
        <?php endif; ?>
        
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5 no-print">
            <a href="/" class="btn btn-primary btn-lg px-4 gap-3">Go to Dashboard</a>
            <a href="/store" class="btn btn-outline-secondary btn-lg px-4">Continue Shopping</a>
        </div>
        
        <div class="mt-5 p-4 bg-light rounded shadow-sm text-start no-print">
            <h6 class="fw-bold mb-3">Order Information:</h6>
            <ul class="mb-0 small text-muted">
                <li class="mb-2">Your stock levels have been automatically updated.</li>
                <li class="mb-2">This order has been recorded in your lifetime sales.</li>
                <li>You can view all past orders in the User Management section.</li>
            </ul>
        </div>
    </div>
</div>
            <h6 class="fw-bold mb-3">Next Steps:</h6>
            <ul class="mb-0 small">
                <li class="mb-2">You will receive a notification once your order is being picked.</li>
                <li class="mb-2">A quality check will be performed before packing.</li>
                <li>You'll get a tracking link when the rider is out for delivery.</li>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
