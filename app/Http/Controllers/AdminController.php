<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('layouts.admin', [
            'tab' => 'users'
        ]);
    }

    public function permission()
    {
        return view('layouts.admin', [
            'tab' => 'permission-management'
        ]);
    }

    public function groups()
    {
        return view('layouts.admin', [
            'tab' => 'groups-management'
        ]);
    }

    public function feedbacks()
    {
        return view('layouts.admin', [
            'tab' => 'feedbacks-management'
        ]);
    }

    public function cache()
    {
        return view('layouts.admin', [
            'tab' => 'cache-management'
        ]);
    }
}
