<?php

namespace Tests\Feature;

use Tests\TestCase;

class StatTest extends TestCase {
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStatus() {
        $response = $this->get('/api/books/stat');
        $response->assertStatus(200);
    }
}
