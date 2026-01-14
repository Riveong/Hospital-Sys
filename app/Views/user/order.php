<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Medicines</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 24px; }
        .navbar-right { display: flex; align-items: center; gap: 20px; }
        .nav-links { display: flex; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
        .btn-logout { padding: 8px 20px; background: rgba(255,255,255,0.2); color: white; border: 1px solid white; border-radius: 5px; text-decoration: none; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .order-form { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .medicine-item { display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #eee; }
        .medicine-info { flex: 1; }
        .medicine-info h3 { color: #333; margin-bottom: 5px; }
        .medicine-info .price { color: #667eea; font-weight: bold; }
        .medicine-info .stock { color: #666; font-size: 14px; }
        .quantity-input { display: flex; align-items: center; gap: 10px; }
        .quantity-input input { width: 80px; padding: 8px; border: 2px solid #e0e0e0; border-radius: 5px; text-align: center; }
        .total-section { margin-top: 30px; padding-top: 20px; border-top: 2px solid #eee; }
        .total { font-size: 24px; font-weight: bold; color: #333; text-align: right; }
        .btn-submit { width: 100%; padding: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 5px; font-size: 18px; font-weight: 600; cursor: pointer; margin-top: 20px; }
        .btn-submit:hover { transform: translateY(-2px); }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-error { background: #fee; color: #c33; border: 1px solid #fcc; }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏥 Order Medicines</h1>
        <div class="navbar-right">
            <div class="nav-links">
                <a href="<?= base_url('user') ?>">Home</a>
                <a href="<?= base_url('user/my-orders') ?>">My Orders</a>
            </div>
            <a href="<?= base_url('auth/logout') ?>" class="btn-logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('user/place-order') ?>" method="post" class="order-form">
            <?= csrf_field() ?>
            
            <h2 style="margin-bottom: 20px;">Select Medicines</h2>
            
            <?php foreach ($medicines as $med): ?>
                <div class="medicine-item">
                    <div class="medicine-info">
                        <h3><?= esc($med['name']) ?></h3>
                        <div class="price">Rp <?= number_format($med['price'], 0, ',', '.') ?> / <?= $med['unit'] ?></div>
                        <div class="stock">Available: <?= $med['stock'] ?> <?= $med['unit'] ?></div>
                    </div>
                    <div class="quantity-input">
                        <label>Qty:</label>
                        <input type="number" name="cart[<?= $med['id'] ?>]" min="0" max="<?= $med['stock'] ?>" value="0" class="qty-input" data-price="<?= $med['price'] ?>">
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="total-section">
                <div class="total">Total: Rp <span id="totalAmount">0</span></div>
            </div>

            <button type="submit" class="btn-submit">Place Order</button>
        </form>
    </div>

    <script>
        const inputs = document.querySelectorAll('.qty-input');
        const totalSpan = document.getElementById('totalAmount');
        
        function calculateTotal() {
            let total = 0;
            inputs.forEach(input => {
                const qty = parseInt(input.value) || 0;
                const price = parseInt(input.dataset.price);
                total += qty * price;
            });
            totalSpan.textContent = total.toLocaleString('id-ID');
        }
        
        inputs.forEach(input => {
            input.addEventListener('input', calculateTotal);
        });
    </script>
</body>
</html>
