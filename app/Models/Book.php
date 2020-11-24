<?php

namespace App\Models;

use App\Helpers\DateFormatTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, DateFormatTrait;

    /**
     * parameter pre prefixovanie linkov buttonov v tabulke SimpleTable
     */
    const ENTITY_ROUTE_PREFIX = 'books';
    const INDEX_VIEW_PAGINATION = true;
    const INDEX_VIEW_PER_PAGE_SELECT = true;

    const IS_BORROWED_FALSE = '0';
    const IS_BORROWED_TRUE = '1';

    protected $appends = ['author_full_name', 'is_borrowed_label'];

    protected $fillable = [
        'title',
        'is_borrowed',
        'author_id',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function getAuthorFullNameAttribute()
    {
        return $this->author->name . ' ' . $this->author->surname;
    }

    public function getIsBorrowedLabelAttribute()
    {
        switch ($this->is_borrowed) {
            case self::IS_BORROWED_TRUE:
                return __('general.Yes');
            case self::IS_BORROWED_FALSE:
                return __('general.No');
        }
    }
}
