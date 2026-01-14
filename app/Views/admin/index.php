<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .navbar { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .nav-links { display: flex; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
        .btn-logout { padding: 8px 20px; background: rgba(255,255,255,0.2); color: white; border: 1px solid white; border-radius: 5px; text-decoration: none; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .stat-card h3 { font-size: 40px; color: #e74c3c; margin-bottom: 10px; }
        .stat-card p { color: #666; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .stock-table { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #e74c3c; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .low-stock { color: #e74c3c; font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏥 Admin Dashboard</h1>
        <div style="display: flex; align-items: center; gap: 20px;">
            <div class="nav-links">
                <a href="<?= base_url('admin') ?>">Dashboard</a>
                <a href="<?= base_url('admin/stock') ?>">Stock Management</a>
                <a href="<?= base_url('admin/orders') ?>">Orders</a>
                <a href="<?= base_url('admin/opname') ?>">Stock Opname</a>
            </div>
            <span><?= esc(session()->get('username')) ?></span>
            <a href="<?= base_url('auth/logout') ?>" class="btn-logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <h3><?= count($medicines) ?></h3>
                <p>Total Medicines</p>
            </div>
            <div class="stat-card">
                <h3><?= $totalOrders ?></h3>
                <p>Total Orders</p>
            </div>
            <div class="stat-card">
                <h3>Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h3>
                <p>Total Revenue</p>
            </div>
        </div>

        <div class="stock-table">
            <h2>Current Stock</h2>
            <table>
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicines as $med): ?>
                        <tr>
                            <td><?= esc($med['name']) ?></td>
                            <td>Rp <?= number_format($med['price'], 0, ',', '.') ?></td>
                            <td><?= $med['stock'] ?> <?= $med['unit'] ?></td>
                            <td class="<?= $med['stock'] < 20 ? 'low-stock' : '' ?>">
                                <?= $med['stock'] < 20 ? '⚠ Low Stock' : '✓ OK' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
