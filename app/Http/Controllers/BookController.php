<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(){
        $books =  Book::all();
        return $books;
    }
    
    public function show($id)
    {
        $book = Book::find($id);
        return $book;
    }
    public function destroy($id)
    {
        Book::find($id)->delete();
    }
    public function store(Request $request)
    {
        $Book = new Book();
        $Book->author = $request->author;
        $Book->title = $request->title;
        $Book->save();
    }

    public function update(Request $request, $id)
    {
        $Book = Book::find($id);
        $Book->author = $request->author;
        $Book->title = $request->title;
    }

    public function bookCopies($title)
    {	
        $copies = Book::with('copy_c')->where('title','=', $title)->get();
        return $copies;
    }

    // Lekérdezések:
    // Csoportosítsd a könyveket a szerzők szerint növekvő sorrendben!
    public function authorBooks() {
        $books = DB::table('books')
        ->select('author','title')
        ->orderBy('author')
        ->get();
        return $books;
    }

    // Határozd meg a könyvtár nyilvántartásában legalább 2 könyvvel rendelkező szerzőket!
    public function authorsMin($number) {
        $books = DB::table('books')
        ->selectRaw('author, COUNT(*)')
        ->groupBy('author')
        ->having('COUNT(*)', '>=', $number)
        ->get();
        return $books;
    }

    // A B betűvel kezdődő szerzőket add meg!
    public function authorsB() {
        $authors = DB::table('books')
        ->select('author')
        ->whereRaw('author LIKE "B%"')
        ->get();
        return $authors;
    }

    // Felső lekérdezés paraméteresen:
    public function authorsStartsWith($char) {
        $authors = DB::table('books')
        ->selectRaw('DISTINCT author')
        ->whereRaw("author LIKE '${char}%'")
        ->get();
        return $authors;
    }


}
