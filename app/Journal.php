<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Journal
 *
 * @property int                             $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int                             $book_id
 * @property-read \App\Book                  $book
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal filterByDate(\Carbon\Carbon $from = null, \Carbon\Carbon $to = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Journal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Journal extends Model {
    protected $table = 'journal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['book_id',];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function scopeFilterByDate(Builder $query, Carbon $from = null, Carbon $to = null) {
        if (is_null($from) && is_null($to)) {
            return $query;
        }

        return $query->when($from, function(Builder $query, $from) {
            $query->where('created_at', '>=', $from);
        })->when($to, function(Builder $query, $to) {
                $query->where('created_at', '<=', $to);
            });
    }

    public static function getdata($request) : Array {
        $book = $mount = $year = [];

        $joornals = self::filterByDate($request->from(), $request->to())->with('book')->get();
        foreach ($joornals->groupBy('book_id') as $value) {
            $book[] = ['date' => $value->first()->created_at->format('Y-m'), 'title' => $value->first()->book->title, 'value' => $value->count()];
        }

        $mounts = $joornals->groupBy(function($val) {
            return Carbon::parse($val->created_at)->format('Y-m');
        });
        foreach ($mounts as $value) {
            $mount[] = ['date' => $value->first()->created_at->format('Y-m'), 'value' => $value->count()];
        }

        $years = $joornals->groupBy(function($val) {
            return Carbon::parse($val->created_at)->format('Y');
        });
        foreach ($years as $value) {
            $year[] = ['date' => $value->first()->created_at->format('Y'), 'value' => $value->count()];
        }

        return array_values(array_merge($book,$mount,$year,[['value'=>$joornals->count()]]));
    }
}
