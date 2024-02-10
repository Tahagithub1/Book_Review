<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
    use HasFactory;


    public function Reviews()  {

           return $this->hasMany(Review::class);

    }

    public function scopeTitle(Builder $query , string $title) : Builder|QueryBuilder
    {
       return $query->where('title','LIKE' , '%' . $title . '%');
    }

    public function scopeWithReviewsCount(Builder $query , $form = null , $to = null) : Builder|QueryBuilder  {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dataRangFilter($q , $form , $to)
        ]);

    }

    public function scopeWithAvgRating(Builder $query , $form = null , $to = null) : Builder|QueryBuilder  {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dataRangFilter($q , $form , $to)
         ], 'rating');
    }

    public function scopePopular(Builder $query , $form = null , $to = null) : Builder|QueryBuilder {
         return $query->withReviewsCount()->orderBy('review_count','desc');

        //  withCount([
        //     'reviews' => fn(Builder $q) => $this->dataRangFilter($q , $form , $to)
        //  ])

    }
    public function scopeHighsetRating(Builder $query , $form = null , $to = null ) : Builder|QueryBuilder {
          return $query->withAvgRating()->orderBy('review_avg_rating' , 'desc');
        //   withAvg([
        //           'reviews' => fn(Builder $q) => $this->dataRangFilter($q , $form , $to)
        //   ], 'rating')
    }
    public function scopeMineReviews(Builder $query , int $minReviews) : Builder|QueryBuilder {
        return $query->having('reviews_count' , '>=' , $minReviews);
  }

    private function dataRangFilter(Builder $query , $form = null , $to = null)  {
        if($form && !$to){
            $query->where('cearted_at' , '>=' , $form);
        }elseif(!$form && $to){
            $query->where('cearted_at' , '<=' , $to);
        }elseif($form && $to){
            $query->whereBetween('created_at' , [$form,$to]);
        }
    }

    public function ScopePopularLastMonth(Builder $query) : Builder|QueryBuilder {

      return $query->popular(now()->subMonth(),now())
      ->highsetRating(now()->subMonth(),now())
      ->mineReviews(2);

    }

    public function scopePopularLast6Months(Builder $query) : Builder|QueryBuilder {

        return $query->popular(now()->subMonth(),now())
        ->highsetRating(now()->subMonth(6),now())
        ->mineReviews(5);

      }

    public function scopeHighsetRatingLastMonth(Builder $query) : Builder|QueryBuilder {

        return $query->highsetRating(now()->subMonth(),now())
        ->popular(now()->subMonth(),now())
        ->mineReviews(2);

      }

    public function scopeHighsetRatingLast6Months(Builder $query) : Builder|QueryBuilder {

        return $query->highsetRating(now()->subMonth(6),now())
        ->popular(now()->subMonth(),now())
        ->mineReviews(5);

      }


      protected static function booted()  {
        static::updated(fn(Book $book)=> cache()->forget('book:' . $book->id));
        static::deleted(fn(Book $book) => cache()->forget('book:' . $book->id));
 }

}
