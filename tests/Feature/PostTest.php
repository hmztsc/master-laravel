<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Comments;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('no content');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title',
        ]);
    }

    public function testSee1BlogPostWithComments(){
        
        // Arrange
        $post = $this->createDummyBlogPost();


        Comments::factory(4)->create(
            [
                'blog_post_id' => $post->id
            ]
        );
        
        // Act
        $response = $this->get('/posts');
        $response->assertSeeText("4 comments.");
    }

    public function testStoreValid()
    {

        $params = [
            'title' => 'Valid ti',
            'content' => 'At least 10 charactesrs',
        ];
        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFails()
    {

        $params = [
            'title' => 'x',
            'content' => 'x',
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();
        $this->assertDatabaseHas('blog_posts', $post->getAttributes());

        $params = [
            'title' => 'A new name',
            'content' => 'Content was changed',
        ];

        $this->actingAs($this->user())
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Update success.');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());

        $this->assertDatabaseHas('blog_posts', $params);
    }

    public function testDelete()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts' ,$post->getAttributes());

        $this->actingAs($this->user())
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');
            
        $this->assertEquals(session('status'), 'Blog post was delete!');
        // $this->assertDatabaseMissing('blog_posts', $post->getAttributes());
        $this->assertSoftDeleted('blog_posts', $post->getAttributes());
    }

    private function createDummyBlogPost(): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'New Content Blog Post';
        // $post->save();

        return BlogPost::factory()->newTitle()->create();

        // return $post;
    }
}
