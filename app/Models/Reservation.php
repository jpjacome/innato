<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'destination_id',
        'people_count',
        'date',
        'phone_number',
    ];

    // Relationship: destination (foreign key destination_id)
    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }
}
