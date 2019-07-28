<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function store(Request $request)
    {
    	$book = Book::create($this->validateForm($request));

    	return redirect($book->path());
    }

    public function update(Request $request, Book $book)
    {
    	$book->update($this->validateForm($request));

    	return redirect($book->path());
    }

    public function delete(Book $book)
    {
    	$book->delete($book);

    	return redirect('/books');
    }

    private function validateForm($request)
    {
    	return $request->validate([
			'title' => 'required',
			'author_id' => 'required'    		
    	]);
    }

}
