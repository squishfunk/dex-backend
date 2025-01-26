<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Token;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_a_new_token()
    {
        $payload = [
            'name' => 'MyToken',
            'symbol' => 'MTK',
            'supply' => 1000000,
            'logoURL' => 'https://example.com/logo.png',
            'description' => 'This is a test token.',
            'contractAddress' => '0x1234567890abcdef1234567890abcdef12345678',
            'deployerAddress' => '0xabcdefabcdefabcdefabcdefabcdefabcdefabcd',
        ];

        $response = $this->postJson('/api/tokens', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Token created successfully!',
                'token' => [
                    'name' => 'MyToken',
                    'symbol' => 'MTK',
                    'supply' => 1000000,
                ]
            ]);

        $this->assertDatabaseHas('tokens', $payload);
    }


    /** @test */
    public function it_fails_to_store_token_with_invalid_data()
    {
        $payload = [
            'name' => '',
            'symbol' => '',
            'supply' => 'not-a-number',
            'contractAddress' => 'invalid-address',
        ];

        $response = $this->postJson('/api/tokens', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'symbol',
                'supply',
                'deployerAddress',
            ]);
    }


    /** @test */
    public function it_can_list_all_tokens()
    {
        Token::factory()->count(3)->create();

        $response = $this->getJson('/api/tokens');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'symbol', 'supply', 'contractAddress', 'deployerAddress', 'created_at', 'updated_at'],
            ]);
    }
}
