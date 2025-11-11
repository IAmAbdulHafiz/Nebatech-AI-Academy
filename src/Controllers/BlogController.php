<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;

class BlogController extends Controller
{
    public function index()
    {
        echo $this->view('blog.index', [
            'title' => 'Blog & Resources'
        ]);
    }

    public function show(string $slug)
    {
        echo $this->view('blog.show', [
            'title' => 'Article',
            'slug' => $slug
        ]);
    }
}
