@extends('Layout.app')

@section('content')

<h2 class="mb-4 py-2">Books</h2>


@forelse ($books as $book )

<li class="mb-4" >
    <div class="book-item">
      <div
        class="flex flex-wrap items-center justify-between">
        <div class="w-full flex-grow sm:w-auto">
          <a href="{{ route('books.show' , $book ) }}" class="book-title">{{ $book->title }}</a>
          <span class="book-author">{{ $book->author }}</span>
        </div>
        <div>
          <div class="book-rating">
            {{ number_format($book->review_avg_rating , 5) }}
          </div>
          <div class="book-review-count">
          out of  {{ $book->reviews_count }}  {{ Str::plural('review', $book->reviews_count) }}
          </div>
        </div>
      </div>
    </div>
  </li>

@empty

<li class="mb-4">
    <div class="empty-book-item">
      <p class="empty-text">No books found</p>
      <a href="{{ route('books.index') }}" class="reset-link">Reset Page</a>
    </div>
  </li>

@endforelse



@endsection
