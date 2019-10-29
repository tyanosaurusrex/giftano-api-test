<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItemIndex()
    {
        $response = $this->json('GET', '/api/items');
        $response->assertStatus(200);
    }

    public function testItemStore()
    {
        $items = [
            'name' => 'Item',
            'category_id' => 1
        ];

        $response = $this->json('POST', '/api/items', $items);
        $response->assertStatus(200);
        $response->assertJsonFragment($items);
    }

    public function testItemUpdate()
    {
        $items = [
            'name' => 'Item',
            'category_id' => 1
        ];

        $response = $this->json('PUT', '/api/items/1', $items);
        $response->assertStatus(200);
        $response->assertJsonFragment($items);
    }
    
    public function testItemDestroy()
    {
        $items = [
            'id' => 1,
            'name' => 'Item',
            'category_id' => 1
        ];
        $response = $this->delete('/api/items/100');
        $response->assertStatus(204);
    }
}
