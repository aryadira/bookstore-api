<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    public function showRentByUser()
    {
        $user = Auth::user();

        $rents = Rent::where('user_id', $user->id)->get();

        return response()->json([
            'user' => $user->id,
            'rents' => $rents
        ]);
    }

    public function storeRent($book_id)
    {
        $user = Auth::user();
        $book = Book::where('id', $book_id)->first();

        if ($user->id == $book->user_id) {
            return response()->json([
                'message' => 'You cant rent your own book!'
            ]);
        }

        $rent = Rent::where('user_id', $user->id)->where('book_id', $book_id)->first();

        if ($rent !== null) {
            return response()->json([
                'message' => 'Book has been rented'
            ]);
        }

        if (Rent::where('book_id', $book->id)->exists()) {
            return response()->json([
                'message' => 'Book has been rented by another user!'
            ]);
        }

        $newRent = Rent::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rent_date' => date('Y:m:d H:i:s')
        ]);

        return response()->json([
            'user' => $user->id,
            'book' => $book,
            'rent_date' => $newRent->rent_date,
        ]);
    }

    public function returnRent($book_id)
    {
        $user = Auth::user();
        $book = Book::where('id', $book_id)->orWhere('user_id', $user->id)->first();

        $rent = Rent::where('user_id', $user->id)->orWhere('book_id', $book_id)->first();

        $rent->update([
            'rent_return' => date('Y:m:d H:i:s'),
        ]);

        return response()->json([
            'user' => $user->id,
            'book' => $book->title,
            'rent_return' => $rent->rent_return
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
