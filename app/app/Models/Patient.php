<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'name',
        'mother_name',
        'birth_date',
        'cpf',
        'cns',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'address',
    ];

    /**
     * A user has one address.
     * 
     * @return A single address record.
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    /**
     * It searches for a given term in the name and cpf fields of the database, and returns the results
     * paginated
     * 
     * @param searchTerm The search term that the user typed in the search box.
     * 
     * @return object A collection of objects
     */
    public static function search($searchTerm): object
    {
        return self::where('name', 'like', "%{$searchTerm}%")
            ->orWhere('cpf', 'like', "%{$searchTerm}%")
            ->paginate(10);
    }
}
