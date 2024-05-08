<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Basecontroller extends Controller
{
    public function about() 
    {
        return view('page.about');
    }
    public function Privacy_Policy()
    {
        return view('page.privacy');
    }
    public function contact()
    {
        return view('page.contact');
    }
    public function help()
    {
        return view('page.help');
    }
    public function search()
    {
        return view('page.search');
    }
}