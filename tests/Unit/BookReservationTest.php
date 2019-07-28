<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;
use App\User;
use App\Reservation;

class BookReservationTest extends TestCase
{	

	use RefreshDatabase;

	/** @test */
    public function a_book_can_be_checkout()
    {

    	$book = factory(Book::class)->create();
    	$user = factory(User::class)->create();

    	$book->checkout($user);

    	$this->assertCount(1, Reservation::all());
    	$this->assertEquals($book->id, Reservation::first()->book_id);
    	$this->assertEquals($user->id, Reservation::first()->user_id);
    	$this->assertEquals(now(), Reservation::first()->check_out_at);

    }

    /** @test */
    public function a_book_can_returned()
    {
    	$book = factory(Book::class)->create();
    	$user = factory(User::class)->create();

    	$book->checkout($user);
    	$book->checkin($user);

    	$book->checkout($user);

    	$this->assertCount(2, Reservation::all());
    	$this->assertEquals($book->id, Reservation::find(3)->book_id);
    	$this->assertEquals($user->id, Reservation::find(3)->user_id);
    	$this->assertNull(Reservation::find(3)->check_in_at);
    	$this->assertEquals(now(), Reservation::find(3)->check_out_at);

    	$book->checkin($user);

    	$this->assertCount(2, Reservation::all());
    	$this->assertEquals($book->id, Reservation::find(3)->book_id);
    	$this->assertEquals($user->id, Reservation::find(3)->user_id);
    	$this->assertNotNull(Reservation::find(3)->check_in_at);
    	$this->assertEquals(now(), Reservation::find(3)->check_in_at);
    }
}
