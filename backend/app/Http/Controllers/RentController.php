<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Rent;
use App\Models\RentReturn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    public function showRentByUser()
    {
        $user = Auth::user();

        $rents = Rent::where('user_id', $user->id)->get();

        if ($rents->count() == 0) {
            return response()->json([
                'message' => 'You havent rent a book'
            ]);
        }

        return response()->json([
            'user' => $user->id,
            'rents' => $rents
        ]);
    }

    public function storeRent($book_id)
    {
        $user = Auth::user();
        $book = Book::where('id', $book_id)->first();

        // kalo id user yg login sama kaya user_id buku
        if ($user->id == $book->user_id) {
            return response()->json([
                'message' => 'You cant rent your own book!'
            ]);
        }

        $rent = Rent::where('user_id', $user->id)->where('book_id', $book_id)->first();

        // kalo bukunya sudah di rent sama diri sendiri
        if ($rent !== null) {
            return response()->json([
                'message' => 'Book has been rented'
            ]);
        }

        // kalo bukunya sudah di rent sama orng lain
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
