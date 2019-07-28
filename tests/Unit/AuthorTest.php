<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Author;

class AuthorTest extends TestCase
{
   
	use RefreshDatabase;

	/** @test */
	public function only_name_is_required()
	{
		Author::create([
			'name' => 'Author Name'
		]);

		$this->assertCount(1, Author::all());
	}

}
