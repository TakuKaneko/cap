<?php

/*
 * This file is part of the CAP service.
 *
 * Copyright © <2018> PASONATECH.CO., LTD. All rights reserved.
 * 
 * This source code or any portion thereof must not be
 * reproduced or used in any manner whatsoever.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // ダッシュボードトップの表示
    public function index() 
    {
        return view('dashboard.top');
    }

    // データベースのリフレッシュ
    // public function migrateRefresh()
    // {
    //     Artisan::call('migrate:refresh');
    //     Artisan::call('db:seed');
    //     return redirect('/')->with('msg', 'DBのリフレッシュが完了しました。');
    // }
}
