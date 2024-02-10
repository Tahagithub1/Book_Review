@extends('Layout.app')

@section('content')

<h2 class="mb-4 py-2 text-2xl">Books</h2>

<form method="GET" action="{{ route('books.index') }}" class="mb-4 flex items-center space-x-2">
    <input type="hidden" name="filter" value="{{ request('filter') }}">
    <input class="input " type="text" name="title" placeholder="search with title" value="{{ request('title') }}">

    <button class="btn" type="submit" > search </button>
    <a class="btn" href="{{ route('books.index') }}"> clear </a>
</form>

<div class="filter-container">


@php

    $filters = [
          '' => 'جدید ترین کتاب ها',
          'popular_last_month' => 'محبوب ترین ها در یک ماه اخیر',
          'popular_last_6months' => 'محبوب ترین ها در شیش ماه اخیر',
          'highest_rated_last_month' => 'بهترین امتیازات در یک ماه اخیر',
          'highest_rated_last_6months' => 'بهترین امتیازات در شیش ماه اخیر',

];

@endphp

@foreach ($filters as $key => $lable )

<a href="{{ route('books.index' , [...request()->query() ,'filter' => $key]) }}" class="{{ request('filter') === $key || request('filter') === null && $key === '' ? 'filter-item-active' : 'filter-item' }}">{{ $lable }}</a>

@endforeach

</div>


<ul>
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
            {{ number_format($book->reviews_avg_rating , 1) }}
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


</ul>
@endsection
