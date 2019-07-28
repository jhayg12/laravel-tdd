<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Author;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{   

    use RefreshDatabase;

    /** @test */
    public function a_author_can_be_added()
    {

        $this->withoutExceptionHandling();

        $this->post('/api/authors', [
            'name' => 'Author Name',
            'dob' => '01/19/1993'
        ]);

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1993-01-19', $author->first()->dob->format('Y-m-d'));

    }
}
