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

    public function scopePopular(Builder $query , $form = null , $to = null) : Builder|QueryBuilder {
         return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dataRangFilter($q , $form , $to)
         ])
         ->orderBy('review_count','desc');
    }
    public function scopeHighsetRating(Builder $query , $form = null , $to = null ) : Builder|QueryBuilder {
          return $query->withAvg([
                  'reviews' => fn(Builder $q) => $this->dataRangFilter($q , $form , $to)
          ], 'rating')
          ->orderBy('review_avg_rating' , 'desc');
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

}
