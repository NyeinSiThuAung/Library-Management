<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Retrieves a list of all books.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    /**
     * Creates a new book.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBookRequest $request)
    {
        Book::create($request->validated());

        return response()->json(['message' => 'Book created successfully'], 201);
    }

    /**
     * Updates an existing book.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);

        $book->update($request->validated());

        return response()->json(['message' => 'Book updated successfully'], 200);
    }

    /**
     * Deletes an existing book.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Book::findOrFail($id)->delete();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
