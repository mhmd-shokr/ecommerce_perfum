<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ReviewFilter
{
    protected const ALLOWED_SORT = [
        'created_at',
        'rating',
    ];


    public function apply(Builder $query, array $filters = []): Builder
    {

        // Search
        $query->when($filters['search'] ?? null, function($query,$search){

            $query->where(function($q) use($search){

                $q->where('comment','like',"%{$search}%")
                    ->orWhereHas('user',function($q) use($search){
                        $q->where('name','like',"%{$search}%")
                          ->orWhere('email','like',"%{$search}%");
                    })
                    ->orWhereHas('product',function($q) use($search){
                        $q->where('name->en','like',"%{$search}%")
                          ->orWhere('name->ar','like',"%{$search}%");
                    });

            });

        });


        // Approval
        $query->when(isset($filters['is_approved']), function($query) use($filters){

            $query->where(
                'is_approved',
                filter_var($filters['is_approved'], FILTER_VALIDATE_BOOLEAN)
            );

        });


        // Rating
        $query->when($filters['rating'] ?? null, function($query,$rating){

            $query->where('rating',$rating);

        });


        // Sort
        $query->when($filters['sort'] ?? null,

            function($query,string $sort){

                $direction = str_starts_with($sort,'-')
                    ? 'desc'
                    : 'asc';

                $column = ltrim($sort,'-');


                if(in_array($column,self::ALLOWED_SORT)){

                    $query->orderBy($column,$direction);

                }else{

                    $query->latest();

                }

            },

            fn($query)=>$query->latest()

        );


        return $query;
    }
}
