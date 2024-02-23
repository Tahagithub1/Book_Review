<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Message;
class ReviweController extends Controller
{
    public function __construct()
    {

    //  $this->middleware('throttle:Limit')->only(['store']);


    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        return view('books.reviews.create', ['book' => $book]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , Book $book)
    {
        $Data = $request->validate([
                'review' => 'required|min:15',
                'rating' => 'required|min:1|max:5|integer'
        ]);
        $book->reviews()->create($Data);
      return  redirect()->route('books.show' , $book);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
