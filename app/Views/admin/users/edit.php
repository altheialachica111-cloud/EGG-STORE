<?= $this->extend('layout_dashboard') ?>

<?= $this->section('title') ?>Edit User<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil me-2 text-primary"></i>Edit User: <?= esc($user->username) ?></h5>
            </div>
            <div class="card-body p-4">
                <?php if (session('errors')) : ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="/admin/users/update/<?= $user->id ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= old('username', $user->username) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', $user->email) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Password (Leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/admin/users" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
