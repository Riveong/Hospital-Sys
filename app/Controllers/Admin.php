<?php

namespace App\Controllers;

class Admin extends BaseController
{
    private $dataPath = WRITEPATH . 'data/';
    private $ordersFile = 'orders.json';
    private $stockFile = 'stock.json';
    private $opnameFile = 'opname.json';

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $stock = json_decode(file_get_contents($this->dataPath . $this->stockFile), true);
        $orders = json_decode(file_get_contents($this->dataPath . $this->ordersFile), true);

        return view('admin/index', [
            'medicines' => $stock,
            'totalOrders' => count($orders),
            'totalRevenue' => array_sum(array_column($orders, 'total'))
        ]);
    }

    public function stock()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $stock = json_decode(file_get_contents($this->dataPath . $this->stockFile), true);
        return view('admin/stock', ['medicines' => $stock]);
    }

    public function orders()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $orders = json_decode(file_get_contents($this->dataPath . $this->ordersFile), true);
        $orders = array_reverse($orders);

        return view('admin/orders', ['orders' => $orders]);
    }

    public function opname()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $stock = json_decode(file_get_contents($this->dataPath . $this->stockFile), true);
        
        // Load opname history
        $opnameHistory = [];
        if (file_exists($this->dataPath . $this->opnameFile)) {
            $opnameHistory = json_decode(file_get_contents($this->dataPath . $this->opnameFile), true);
        }

        return view('admin/opname', [
            'medicines' => $stock,
            'history' => array_reverse($opnameHistory)
        ]);
    }

    public function saveOpname()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Access denied');
        }

        $actualStock = $this->request->getPost('actual_stock');
        
        // Load current stock
        $stock = json_decode(file_get_contents($this->dataPath . $this->stockFile), true);
        
        // Load opname history
        $opnameHistory = [];
        if (file_exists($this->dataPath . $this->opnameFile)) {
            $opnameHistory = json_decode(file_get_contents($this->dataPath . $this->opnameFile), true);
        }

        $opnameRecord = [
            'date' => date('Y-m-d H:i:s'),
            'week' => date('W, Y'),
            'username' => session()->get('username'),
            'adjustments' => []
        ];

        // Update stock based on opname
        foreach ($actualStock as $medId => $actual) {
            foreach ($stock as &$medicine) {
                if ($medicine['id'] == $medId) {
                    $systemStock = $medicine['stock'];
                    $difference = $actual - $systemStock;
                    
                    $opnameRecord['adjustments'][] = [
                        'medicine' => $medicine['name'],
                        'system_stock' => $systemStock,
                        'actual_stock' => (int)$actual,
                        'difference' => $difference
                    ];
                    
                    $medicine['stock'] = (int)$actual;
                    break;
                }
            }
        }

        // Save updated stock
        file_put_contents($this->dataPath . $this->stockFile, json_encode($stock, JSON_PRETTY_PRINT));
        
        // Save opname record
        $opnameHistory[] = $opnameRecord;
        file_put_contents($this->dataPath . $this->opnameFile, json_encode($opnameHistory, JSON_PRETTY_PRINT));

        return redirect()->to('/admin/opname')->with('success', 'Stock opname completed successfully!');
    }
}
