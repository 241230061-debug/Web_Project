<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('welcome');
    }

    // Fungsi untuk halaman harga
    public function harga() {
        return view('partials.harga');
    }

    // Fungsi untuk halaman kontak
    public function kontak() {
        return view('partials.kontak');
    }
}