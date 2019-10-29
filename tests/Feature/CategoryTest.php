<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCategoryIndex()
    {
        $response = $this->json('GET', '/api/categories');
        $response->assertStatus(200);
    }

    public function testCategoryStore()
    {
        $categories = [
            'name' => 'Cat',
            'parent' => 0
        ];

        $response = $this->json('POST', '/api/categories', $categories);
        $response->assertStatus(200);
        $response->assertJsonFragment($categories);
    }

    public function testCategoryUpdate()
    {
        $categories = [
            'name' => 'Cat',
            'parent' => 1
        ];

        $response = $this->json('PUT', '/api/categories/18', $categories);
        $response->assertStatus(200);
        $response->assertJsonFragment($categories);
    }
    
    public function testCategoryDestroy()
    {
        $categories = [
            'id' => 1,
            'name' => 'Cat',
            'parent' => 1
        ];
        $response = $this->json('delete', '/api/categories/1');
        // 500 because category still used in item
        $response->assertStatus(500);
    }
}
