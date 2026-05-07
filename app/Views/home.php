<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Egg Store - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,.08); }
        .hero { padding: 60px 0; background: #fff; border-bottom: 1px solid #eee; margin-bottom: 40px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">🥚 EGG STORE</a>
        <div class="ms-auto">
            <span class="me-3 text-muted">Hello, <?= auth()->user()->username ?></span>
            <a href="<?= url_to('logout') ?>" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="hero">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Welcome to Egg Store</h1>
        <p class="lead">Your premium destination for the freshest eggs.</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Manage Inventory</h5>
                    <p class="card-text">Keep track of your egg stock levels and types.</p>
                    <a href="#" class="btn btn-primary btn-sm">View Stock</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Recent Orders</h5>
                    <p class="card-text">View and manage customer orders and deliveries.</p>
                    <a href="#" class="btn btn-primary btn-sm">Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Settings</h5>
                    <p class="card-text">Configure your store profile and notifications.</p>
                    <a href="#" class="btn btn-primary btn-sm">Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
