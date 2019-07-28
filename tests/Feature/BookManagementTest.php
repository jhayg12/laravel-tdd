<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;
use App\Author;

class BookManagementTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_in_the_library()
    {

        $response = $this->post('/api/books', $this->data());

        $this->assertCount(1, Book::all());

        $book = Book::first();

        $response->assertRedirect($book->path());

    }

    /** @test */
    public function a_book_title_is_required()
    {
        $response = $this->post('/api/books', [
            'title' => '',
            'author' => 'Cool Author'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_book_author_is_required()
    {
        $response = $this->post('/api/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/api/books', $this->data());

        $book = Book::first();

        $response = $this->patch('/api/books/' . $book->id, [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', $book->fresh()->title);
        $this->assertEquals(3, $book->fresh()->author_id);

        $response->assertRedirect($book->path());

    }

    /** @test */
    public function a_book_can_be_deleted()
    {   
        $this->post('/api/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete('/api/books/' . $book->id);
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');

    }

    /** @test */
    public function a_new_author_can_be_added_to_the_book()
    {
        $this->post('/api/books', [
            'title' => 'Cool Title',
            'author_id' => 'Cool Author'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());

    }

    private function data()
    {
        return [
            'title' => 'Cool Title',
            'author_id' => 'Cool Author'
        ];
    }

}
