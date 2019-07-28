<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;

class AuthorController extends Controller
{
    public function store(Request $request)
    {

    	$data = $request->validate([
    		'name' => 'required',
    		'dob' => 'required'
    	]);

    	Author::create($data);
    }
}
