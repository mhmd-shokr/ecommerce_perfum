<?php
namespace App\Filters;
use Illuminate\Database\Eloquent\Builder;
class OrderFilter{
    protected const ALLOWED_SORTS = [
        'created_at',
        'total',
        'status',
        'payment_status'
    ];
    public function apply(Builder $query,array $filters):Builder{
        $query->when($filters['search'] ?? null, function($query,$search){
            $query->where(function($q) use($search){
                $q->where('order_number','like',"%{$search}%")
                ->orWhereHas('user',function($q) use($search){
                    $q->where('name','like',"%{$search}%")
                    ->orWhere('email','like',"%{$search}%");
                });
            });
        });
        //status
        $query->when($filters['status'] ?? null,function($query,$status){
            $query->where('status',$status);
        });
        //payment_status
        $query->when($filters['payment_status'] ?? null,function($query,$payment){
            $query->where('payment_status',$payment);
        });
        //sort
        $query->when($filters['sort']??null,function($query,$sort){
            $direction=str_starts_with($sort,'-') ?'desc':'asc';
            $column=ltrim($sort,'-');
            if (in_array($column, self::ALLOWED_SORTS)) {
                $query->orderBy($column, $direction);
            }else{
                $query->latest();
            }
        },
        function($query){
            $query->latest();
        }
        );
            return $query;
        }
}
