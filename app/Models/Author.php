<?php

namespace App\Models;

use App\Helpers\DateFormatTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory, DateFormatTrait;

    /**
     * parameter pre prefixovanie linkov buttonov v tabulke SimpleTable
     */
    const ENTITY_ROUTE_PREFIX = 'authors';
    const INDEX_VIEW_PAGINATION = false;
    const INDEX_VIEW_PER_PAGE_SELECT = false;

    protected $appends = ['full_name', 'number_of_books'];

    protected $fillable = [
        'name',
        'surname',
    ];

    public function books() {
        return $this->hasMany(Book::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setSurnameAttribute($value)
    {
        $this->attributes['surname'] = ucfirst($value);
    }

    /**
     * Function returns author's number of books
     *
     * @return string
     */
    public function getNumberOfBooksAttribute()
    {
        return $this->books()->count();
    }

    /**
     * Function returns author's full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucfirst($this->name) . ' ' . ucfirst($this->surname);
    }
}
