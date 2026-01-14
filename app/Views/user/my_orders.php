<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .nav-links { display: flex; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .orders-list { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .order-item { padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .order-item:last-child { border-bottom: none; }
        .order-info h3 { color: #333; margin-bottom: 5px; }
        .order-info p { color: #666; font-size: 14px; }
        .order-total { font-size: 20px; font-weight: bold; color: #667eea; }
        .btn-view { padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏥 My Orders</h1>
        <div class="nav-links">
            <a href="<?= base_url('user') ?>">Home</a>
            <a href="<?= base_url('user/order') ?>">Order Medicines</a>
            <a href="<?= base_url('auth/logout') ?>">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="orders-list">
            <h2 style="margin-bottom: 20px;">Order History</h2>
            <?php if (empty($orders)): ?>
                <p>No orders yet.</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-item">
                        <div class="order-info">
                            <h3><?= $order['id'] ?></h3>
                            <p><?= date('d F Y, H:i', strtotime($order['date'])) ?></p>
                            <p><?= count($order['items']) ?> items</p>
                        </div>
                        <div class="order-total">Rp <?= number_format($order['total'], 0, ',', '.') ?></div>
                        <a href="<?= base_url('user/invoice/' . $order['id']) ?>" class="btn-view">View Invoice</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
