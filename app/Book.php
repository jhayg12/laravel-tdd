<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Author;

class Book extends Model
{
    protected $table = 'books';
    protected $guarded = [];

    public function path()
    {
    	return 'books/' . $this->id;
    }

    public function checkout($user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'book_id' => $this->id,
            'check_out_at' => now()
        ]);
    }    

    public function checkin($user)
    {
        $reservation = $this->reservations()->where('user_id', $user->id)
            ->whereNotNull('check_out_at')
            ->whereNull('check_in_at')
            ->first();

        $reservation->update([
            'check_in_at' => now()
        ]);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function setAuthorIdAttribute($author_id)
    {
    	$this->attributes['author_id'] = (Author::firstOrCreate([
    		'name' => $author_id
    	]))->id;
    }

}
