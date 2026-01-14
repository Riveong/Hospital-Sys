<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Hospital System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h1 { font-size: 24px; }
        .navbar-right { display: flex; align-items: center; gap: 20px; }
        .nav-links { display: flex; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; transition: background 0.3s; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
        .btn-logout { padding: 8px 20px; background: rgba(255,255,255,0.2); color: white; border: 1px solid white; border-radius: 5px; text-decoration: none; font-weight: 500; transition: all 0.3s; }
        .btn-logout:hover { background: white; color: #667eea; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .welcome-card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; text-align: center; }
        .welcome-card h2 { color: #333; font-size: 32px; margin-bottom: 10px; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .medicine-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .medicine-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .medicine-card h3 { color: #333; margin-bottom: 10px; }
        .medicine-card .price { font-size: 24px; color: #667eea; font-weight: bold; margin: 10px 0; }
        .medicine-card .stock { color: #666; font-size: 14px; }
        .btn-order { display: block; width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 5px; font-size: 16px; font-weight: 600; cursor: pointer; margin-top: 20px; text-align: center; text-decoration: none; }
        .btn-order:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏥 Hospital System - User</h1>
        <div class="navbar-right">
            <div class="nav-links">
                <a href="<?= base_url('user') ?>">Home</a>
                <a href="<?= base_url('user/order') ?>">Order Medicines</a>
                <a href="<?= base_url('user/my-orders') ?>">My Orders</a>
            </div>
            <span>Welcome, <?= esc(session()->get('username')) ?></span>
            <a href="<?= base_url('auth/logout') ?>" class="btn-logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="welcome-card">
            <h2>Welcome, <?= esc(session()->get('username')) ?></h2>
            <p>Order medicines and view your invoices</p>
        </div>

        <h2 style="margin-bottom: 20px;">Available Medicines</h2>
        <div class="medicine-grid">
            <?php foreach ($medicines as $med): ?>
                <div class="medicine-card">
                    <h3><?= esc($med['name']) ?></h3>
                    <div class="price">Rp <?= number_format($med['price'], 0, ',', '.') ?></div>
                    <div class="stock">Stock: <?= $med['stock'] ?> <?= $med['unit'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="<?= base_url('user/order') ?>" class="btn-order">Start Ordering</a>
    </div>
</body>
</html>
