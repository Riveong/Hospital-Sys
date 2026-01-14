<?php

namespace App\Controllers;

class User extends BaseController
{
    private $dataPath = WRITEPATH . 'data/';
    private $ordersFile = 'orders.json';
    private $stockFile = 'stock.json';

    public function __construct()
    {
        // Create data directory if not exists
        if (!is_dir($this->dataPath)) {
            mkdir($this->dataPath, 0755, true);
        }
        
        // Initialize stock file if not exists
        if (!file_exists($this->dataPath . $this->stockFile)) {
            $initialStock = [
                ['id' => 1, 'name' => 'Paracetamol', 'price' => 5000, 'stock' => 100, 'unit' => 'box'],
                ['id' => 2, 'name' => 'Amoxicillin', 'price' => 15000, 'stock' => 50, 'unit' => 'box'],
                ['id' => 3, 'name' => 'Vitamin C', 'price' => 8000, 'stock' => 75, 'unit' => 'bottle'],
                ['id' => 4, 'name' => 'Antibiotic', 'price' => 25000, 'stock' => 30, 'unit' => 'box'],
                ['id' => 5, 'name' => 'Cough Syrup', 'price' => 12000, 'stock' => 60, 'unit' => 'bottle'],
            ];
            file_put_contents($this->dataPath . $this->stockFile, json_encode($initialStock, JSON_PRETTY_PRINT));
        }
        
        // Initialize orders file if not exists
        if (!file_exists($this->dataPath . $this->ordersFile)) {
            file_put_contents($this->dataPath . $this->ordersFile, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $stock = json_decode(file_get_contents($this->dataPath . $this->stockFile), true);
        return view('user/index', ['medicines' => $stock]);
    }

    public function order()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $stock = json_decode(file_get_contents($this->dataPath . $this->stockFile), true);
        return view('user/order', ['medicines' => $stock]);
    }

    public function placeOrder()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $cart = $this->request->getPost('cart');
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        // Load stock
        $stock = json_decode(file_get_contents($this->dataPath . $this->stockFile), true);
        
        // Process order
        $orderItems = [];
        $total = 0;
        
        foreach ($cart as $medId => $quantity) {
            if ($quantity > 0) {
                $medicine = array_filter($stock, fn($m) => $m['id'] == $medId);
                $medicine = reset($medicine);
                
                if ($medicine && $medicine['stock'] >= $quantity) {
                    // Reduce stock
                    foreach ($stock as &$s) {
                        if ($s['id'] == $medId) {
                            $s['stock'] -= $quantity;
                            break;
                        }
                    }
                    
                    $subtotal = $medicine['price'] * $quantity;
                    $orderItems[] = [
                        'medicine' => $medicine['name'],
                        'price' => $medicine['price'],
                        'quantity' => $quantity,
                        'subtotal' => $subtotal
                    ];
                    $total += $subtotal;
                } else {
                    return redirect()->back()->with('error', 'Insufficient stock for ' . ($medicine['name'] ?? 'medicine'));
                }
            }
        }

        // Save updated stock
        file_put_contents($this->dataPath . $this->stockFile, json_encode($stock, JSON_PRETTY_PRINT));

        // Create order
        $orders = json_decode(file_get_contents($this->dataPath . $this->ordersFile), true);
        $orderId = 'INV-' . date('Ymd') . '-' . str_pad(count($orders) + 1, 4, '0', STR_PAD_LEFT);
        
        $newOrder = [
            'id' => $orderId,
            'username' => session()->get('username'),
            'items' => $orderItems,
            'total' => $total,
            'date' => date('Y-m-d H:i:s'),
            'status' => 'completed'
        ];
        
        $orders[] = $newOrder;
        file_put_contents($this->dataPath . $this->ordersFile, json_encode($orders, JSON_PRETTY_PRINT));

        return redirect()->to('/user/invoice/' . $orderId)->with('success', 'Order placed successfully!');
    }

    public function invoice($orderId)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $orders = json_decode(file_get_contents($this->dataPath . $this->ordersFile), true);
        $order = array_filter($orders, fn($o) => $o['id'] === $orderId);
        $order = reset($order);

        if (!$order) {
            return redirect()->to('/user')->with('error', 'Invoice not found');
        }

        return view('user/invoice', ['order' => $order]);
    }

    public function myOrders()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $orders = json_decode(file_get_contents($this->dataPath . $this->ordersFile), true);
        $myOrders = array_filter($orders, fn($o) => $o['username'] === session()->get('username'));
        $myOrders = array_reverse($myOrders);

        return view('user/my_orders', ['orders' => $myOrders]);
    }
}
