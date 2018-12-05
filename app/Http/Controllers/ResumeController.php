<?php

namespace App\Http\Controllers;

class ResumeController extends Controller
{
    public function index()
    {
        return view('resumes.index');
    }

    public function inquery()
    {
        return view('resumes.inquery');
    }
}
