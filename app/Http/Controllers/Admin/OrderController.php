<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display all orders
     */
    public function index()
    {
        return view('admin.orders.index');
    }

    /**
     * Display pending orders
     */
    public function pending()
    {
        return view('admin.orders.pending');
    }

    /**
     * Display processing orders
     */
    public function processing()
    {
        return view('admin.orders.processing');
    }

    /**
     * Display shipped orders
     */
    public function shipped()
    {
        return view('admin.orders.shipped');
    }

    /**
     * Display delivered orders
     */
    public function delivered()
    {
        return view('admin.orders.delivered');
    }

    /**
     * Display refunds
     */
    public function refunds()
    {
        return view('admin.orders.refunds');
    }

    /**
     * Display order exports
     */
    public function exports()
    {
        return view('admin.orders.exports');
    }
}