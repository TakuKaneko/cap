<?php

/*
 * This file is part of the CAP service.
 *
 * Copyright © <2018> PASONATECH.CO., LTD. All rights reserved.
 * 
 * This source code or any portion thereof must not be
 * reproduced or used in any manner whatsoever.
 */

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Corpus;
use App\Http\Controllers\Controller;

class CorpusManagementController extends Controller
{
    // コーパス管理画面の表示
    public function index() {
        return Corpus::all();
    }
}
