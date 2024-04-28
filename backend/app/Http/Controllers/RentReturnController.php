<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rent;
use App\Models\RentReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentReturnController extends Controller
{
    public function returnRent($book_id)
    {
        $user = Auth::user();
        $book = Book::where('id', $book_id)->orWhere('user_id', $user->id)->first();

        $rent = Rent::where('user_id', $user->id)->orWhere('book_id', $book_id)->first();

        $rent_return = RentReturn::create([
            'rent_return' => date('Y:m:d H:i:s'),
        ]);

        return response()->json([
            'user' => $user->id,
            'book' => $book->title,
            'rent_return' => $rent_return->rent_return
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RentReturn $rentReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentReturn $rentReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RentReturn $rentReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentReturn $rentReturn)
    {
        //
    }
}
