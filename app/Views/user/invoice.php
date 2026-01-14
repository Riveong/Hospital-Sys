<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - <?= $order['id'] ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; padding: 20px; }
        .invoice { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 20px rgba(0,0,0,0.1); }
        .invoice-header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #667eea; padding-bottom: 20px; }
        .invoice-header h1 { color: #667eea; font-size: 32px; margin-bottom: 10px; }
        .invoice-info { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-block h3 { color: #666; font-size: 14px; margin-bottom: 5px; }
        .info-block p { color: #333; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #667eea; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; font-size: 18px; background: #f5f5f5; }
        .btn-print { padding: 12px 30px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px; }
        .btn-back { padding: 12px 30px; background: #666; color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .actions { margin-top: 30px; text-align: center; }
        @media print { .actions { display: none; } }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>🏥 INVOICE</h1>
            <p>Hospital Management System</p>
        </div>

        <div class="invoice-info">
            <div class="info-block">
                <h3>Invoice Number:</h3>
                <p><?= $order['id'] ?></p>
            </div>
            <div class="info-block">
                <h3>Date:</h3>
                <p><?= date('d F Y, H:i', strtotime($order['date'])) ?></p>
            </div>
            <div class="info-block">
                <h3>Customer:</h3>
                <p><?= esc($order['username']) ?></p>
            </div>
            <div class="info-block">
                <h3>Status:</h3>
                <p style="color: green; font-weight: bold;">✓ <?= ucfirst($order['status']) ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td><?= esc($item['medicine']) ?></td>
                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= $item['quantity'] ?></td>
                        <td class="text-right">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="3">TOTAL</td>
                    <td class="text-right">Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <div class="actions">
            <button onclick="window.print()" class="btn-print">Print Invoice</button>
            <a href="<?= base_url('user') ?>" class="btn-back">Back to Home</a>
        </div>
    </div>
</body>
</html>
