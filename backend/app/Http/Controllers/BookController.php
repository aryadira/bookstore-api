<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return response()->json([
            'data' => [
                'count' => $books->count(),
                'books' => $books
            ]
        ]);
    }

    public function store(BookStoreRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        $book = Book::create([
            'title' => $data['title'],
            'price' => $data['price'],
            'author' => $data['author'],
            'description' => $data['description'],
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => [
                'book' => $book
            ]
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();

        $book = Book::where('id', $id)->where('user_id', $user->id)->first();

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ]);
        }

        return response()->json([
            'data' => [
                'book' => $book
            ]
        ]);
    }

    public function update(BookUpdateRequest $request, $id)
    {
        $user = Auth::user();
        $data = $request->validated();

        $book = Book::where('id', $id)->where('user_id', $user->id)->first();

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ]);
        }

        $book->title = $data['title'];
        $book->price = $data['price'];
        $book->author = $data['author'];
        $book->description = $data['description'];
        $book->save();

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => [
                'book' => $book
            ]
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $book = Book::where('id', $id)->where('user_id', $user->id)->first();

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ]);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully'
        ]);
    }
}
