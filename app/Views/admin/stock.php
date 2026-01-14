<!DOCTYPE html>
<html>
<head>
    <title>Stock Management</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .navbar { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .nav-links { display: flex; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .stock-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #e74c3c; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .low-stock { background: #fee; }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏥 Stock Management</h1>
        <div class="nav-links">
            <a href="<?= base_url('admin') ?>">Dashboard</a>
            <a href="<?= base_url('admin/orders') ?>">Orders</a>
            <a href="<?= base_url('admin/opname') ?>">Opname</a>
            <a href="<?= base_url('auth/logout') ?>">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="stock-container">
            <h2>Current Stock (Stok di Tangan)</h2>
            <p style="color: #666; margin: 10px 0 20px;">Real-time stock after purchases</p>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Medicine Name</th>
                        <th>Price</th>
                        <th>Current Stock</th>
                        <th>Unit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicines as $med): ?>
                        <tr class="<?= $med['stock'] < 20 ? 'low-stock' : '' ?>">
                            <td><?= $med['id'] ?></td>
                            <td><?= esc($med['name']) ?></td>
                            <td>Rp <?= number_format($med['price'], 0, ',', '.') ?></td>
                            <td><strong><?= $med['stock'] ?></strong></td>
                            <td><?= $med['unit'] ?></td>
                            <td>
                                <?php if ($med['stock'] < 20): ?>
                                    <span style="color: #e74c3c; font-weight: bold;">⚠ Low Stock</span>
                                <?php elseif ($med['stock'] < 50): ?>
                                    <span style="color: #f39c12;">⚡ Medium</span>
                                <?php else: ?>
                                    <span style="color: #27ae60;">✓ Good</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
