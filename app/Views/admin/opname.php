<!DOCTYPE html>
<html>
<head>
    <title>Stock Opname</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .navbar { background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .nav-links { display: flex; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .opname-form { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #e74c3c; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        input[type="number"] { width: 100px; padding: 8px; border: 2px solid #e0e0e0; border-radius: 5px; }
        .btn-submit { padding: 12px 30px; background: #e74c3c; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: 600; }
        .btn-submit:hover { background: #c0392b; }
        .history { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .history-item { padding: 20px; border-bottom: 1px solid #eee; }
        .history-item h3 { color: #333; margin-bottom: 10px; }
        .adjustment { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 10px; padding: 10px; background: #f9f9f9; margin: 5px 0; border-radius: 5px; }
        .difference-positive { color: green; font-weight: bold; }
        .difference-negative { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏥 Stock Opname</h1>
        <div class="nav-links">
            <a href="<?= base_url('admin') ?>">Dashboard</a>
            <a href="<?= base_url('admin/stock') ?>">Stock</a>
            <a href="<?= base_url('admin/orders') ?>">Orders</a>
            <a href="<?= base_url('auth/logout') ?>">Logout</a>
        </div>
    </nav>

    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="opname-form">
            <h2>Weekly Stock Opname</h2>
            <p style="color: #666; margin: 10px 0 20px;">Adjust actual stock based on physical count</p>
            
            <form action="<?= base_url('admin/save-opname') ?>" method="post">
                <?= csrf_field() ?>
                
                <table>
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>System Stock</th>
                            <th>Actual Stock</th>
                            <th>Difference</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicines as $med): ?>
                            <tr>
                                <td><?= esc($med['name']) ?></td>
                                <td><?= $med['stock'] ?> <?= $med['unit'] ?></td>
                                <td>
                                    <input type="number" name="actual_stock[<?= $med['id'] ?>]" 
                                           value="<?= $med['stock'] ?>" min="0" required
                                           class="actual-input" data-system="<?= $med['stock'] ?>" data-id="<?= $med['id'] ?>">
                                </td>
                                <td><span id="diff-<?= $med['id'] ?>">0</span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <button type="submit" class="btn-submit">Save Stock Opname</button>
            </form>
        </div>

        <div class="history">
            <h2>Opname History</h2>
            <?php if (empty($history)): ?>
                <p style="color: #666; margin-top: 20px;">No opname records yet.</p>
            <?php else: ?>
                <?php foreach (array_slice($history, 0, 5) as $record): ?>
                    <div class="history-item">
                        <h3>Week <?= $record['week'] ?> - <?= date('d M Y', strtotime($record['date'])) ?></h3>
                        <p style="color: #666; font-size: 14px;">By: <?= esc($record['username']) ?></p>
                        <?php foreach ($record['adjustments'] as $adj): ?>
                            <div class="adjustment">
                                <span><?= esc($adj['medicine']) ?></span>
                                <span>System: <?= $adj['system_stock'] ?></span>
                                <span>Actual: <?= $adj['actual_stock'] ?></span>
                                <span class="<?= $adj['difference'] >= 0 ? 'difference-positive' : 'difference-negative' ?>">
                                    <?= $adj['difference'] > 0 ? '+' : '' ?><?= $adj['difference'] ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.actual-input');
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const system = parseInt(this.dataset.system);
                const actual = parseInt(this.value) || 0;
                const diff = actual - system;
                const diffSpan = document.getElementById('diff-' + this.dataset.id);
                
                diffSpan.textContent = (diff > 0 ? '+' : '') + diff;
                diffSpan.className = diff >= 0 ? 'difference-positive' : 'difference-negative';
            });
        });
    </script>
</body>
</html>
