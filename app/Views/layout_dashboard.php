<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?> - Egg Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; padding-top: 20px; }
        .sidebar a { color: rgba(255,255,255,.75); text-decoration: none; padding: 10px 20px; display: block; }
        .sidebar a:hover { background: rgba(255,255,255,.1); color: white; }
        .sidebar a.active { background: #0d6efd; color: white; }
        .main-content { padding: 20px; }
        .navbar-custom { background: white; box-shadow: 0 2px 4px rgba(0,0,0,.05); margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0">
            <div class="px-3 mb-4">
                <h4 class="fw-bold text-white">🥚 EGG STORE</h4>
            </div>
            <nav>
                <a href="/" class="<?= url_is('/') ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="/store" class="<?= url_is('store*') ? 'active' : '' ?>">
                    <i class="bi bi-shop me-2"></i> Shop Eggs
                </a>
                <a href="/admin/stock-intake" class="<?= url_is('admin/stock-intake') ? 'active' : '' ?>">
                    <i class="bi bi-box-seam me-2"></i> Stock Intake
                </a>
                <a href="/admin/inventory" class="<?= url_is('admin/inventory') ? 'active' : '' ?>">
                    <i class="bi bi-clipboard-data me-2"></i> Inventory
                </a>
                <a href="/admin/orders" class="<?= url_is('admin/orders*') ? 'active' : '' ?>">
                    <i class="bi bi-cart-check me-2"></i> Order Management
                </a>
                <a href="/admin/users" class="<?= url_is('admin/users*') ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i> User Management
                </a>
                <hr class="mx-3 bg-secondary">
                <a href="<?= url_to('logout') ?>" class="text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            <nav class="navbar navbar-expand-lg navbar-light navbar-custom rounded">
                <div class="container-fluid">
                    <span class="navbar-text">
                        Welcome back, <strong><?= auth()->user()->username ?></strong>
                    </span>
                    <div class="ms-auto d-flex align-items-center">
                        <?php if (isset($expiryAlerts) && $expiryAlerts > 0): ?>
                            <a href="/admin/inventory" class="text-danger me-3 position-relative">
                                <i class="bi bi-bell-fill fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    <?= $expiryAlerts ?>
                                </span>
                            </a>
                        <?php else: ?>
                            <i class="bi bi-bell text-muted me-3 fs-5"></i>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>

            <?php if (session('message')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>

            <?php if (session('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>

            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
