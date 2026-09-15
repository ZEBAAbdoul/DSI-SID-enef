<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualController extends Controller
{
    /**
     * Afficher la vue du manuel d'utilisation.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.manual.index');
    }
}
