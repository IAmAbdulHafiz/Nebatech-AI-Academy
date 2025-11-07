<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;

class HomeController extends Controller
{
    public function index(): string
    {
        return $this->view('home.index', [
            'title' => 'Welcome to Nebatech AI Academy',
            'tagline' => 'Learn by Doing, Master by Practicing'
        ]);
    }

    public function about(): string
    {
        return $this->view('home.about', [
            'title' => 'About Us'
        ]);
    }
}
