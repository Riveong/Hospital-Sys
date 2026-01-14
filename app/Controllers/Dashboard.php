<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Check if logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Please login first');
        }

        return view('dashboard/index');
    }
}
