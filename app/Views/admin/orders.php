<!DOCTYPE html>
<html>
<head>
    <title>All Orders</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .navbar { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .nav-links { display: flex; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .orders-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #e74c3c; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .items-list { font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏥 All Orders</h1>
        <div class="nav-links">
            <a href="<?= base_url('admin') ?>">Dashboard</a>
            <a href="<?= base_url('admin/stock') ?>">Stock</a>
            <a href="<?= base_url('admin/opname') ?>">Opname</a>
            <a href="<?= base_url('auth/logout') ?>">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="orders-container">
            <h2>Order History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr><td colspan="5" style="text-align: center;">No orders yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= esc($order['username']) ?></td>
                                <td><?= date('d M Y, H:i', strtotime($order['date'])) ?></td>
                                <td class="items-list">
                                    <?php foreach ($order['items'] as $item): ?>
                                        <?= esc($item['medicine']) ?> (<?= $item['quantity'] ?>)<br>
                                    <?php endforeach; ?>
                                </td>
                                <td>Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
