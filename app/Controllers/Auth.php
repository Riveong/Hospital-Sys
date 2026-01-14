<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Hardcoded credentials
        $users = [
            'TAS.WEB2' => 'TAS.WEB2',
            'ADMIN.WEB2' => 'ADMIN.WEB2'
        ];

        if (isset($users[$username]) && $users[$username] === $password) {
            // Determine role
            $role = ($username === 'ADMIN.WEB2') ? 'admin' : 'user';
            
            // Set session
            session()->set([
                'username' => $username,
                'role' => $role,
                'logged_in' => true
            ]);
            
            // Redirect based on role
            if ($role === 'admin') {
                return redirect()->to('/admin')->with('success', 'Login successful!');
            } else {
                return redirect()->to('/user')->with('success', 'Login successful!');
            }
        }

        return redirect()->back()->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Logged out successfully');
    }
}
