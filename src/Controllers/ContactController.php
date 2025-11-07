<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;

class ContactController extends Controller
{
    public function index()
    {
        echo $this->view('contact.index', [
            'title' => 'Contact Us'
        ]);
    }

    public function submit()
    {
        // Handle contact form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO: Implement contact form logic
            // For now, redirect back with success message
            header('Location: ' . url('/contact?success=1'));
            exit;
        }
    }
}
