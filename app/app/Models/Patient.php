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

    /**
     * > The `getBirthDateAttribute` function is called when you try to access the `birth_date` attribute
     * of a `User` object
     * 
     * @param value The value of the attribute.
     * 
     * @return The birth date of the user.
     */
    public function getBirthDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * > The `setBirthDateAttribute` function is called when the `birth_date` attribute is set
     * 
     * @param value The value of the attribute.
     */
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = date('Y-m-d', strtotime($value));
    }
}
