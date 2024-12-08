<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowBookRequest;
use App\Models\Borrow;
use App\Models\Book;

class BorrowController extends Controller
{
    /**
     * Borrows a book for the member user.
     *
     * @param  BorrowBookRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrow(BorrowBookRequest $request)
    {
        $book = Book::find($request['book_id']);
        if (!$book->is_available) {
            return response()->json(['message' => 'Book is not available'], 400);
        }

        $book->update(['is_available' => false]);

        Borrow::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        return response()->json(['message' => 'Book borrowed successfully'], 200);
    }

    /**
     * Returns a borrowed book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnBook($id)
    {
        $borrow = Borrow::where('id', $id)->whereNull('returned_at')->first();

        if (!$borrow) return response()->json(['message'=> 'Borrowed book not found'], 404);

        $borrow->update(['returned_at' => now()]);

        $borrow->book->update(['is_available' => true]);

        return response()->json(['message' => 'Book returned successfully'], 200);
    }
}
