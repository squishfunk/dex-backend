<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Crowdsale;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrowdsaleApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_a_new_crowdsale()
    {
        $payload = [
            'rate' => 1.5,
            'deployerAddress' => '0xabcdefabcdefabcdefabcdefabcdefabcdefabcd',
            'tokenAddress' => '0x1234567890abcdef1234567890abcdef12345678',
            'contractAddress' => '0x9876543210abcdef9876543210abcdef98765432',
        ];

        $response = $this->postJson('/api/crowdsale', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Crowdsale created successfully!',
                'crowdsale' => [
                    'rate' => 1.5,
                    'deployerAddress' => '0xabcdefabcdefabcdefabcdefabcdefabcdefabcd',
                    'tokenAddress' => '0x1234567890abcdef1234567890abcdef12345678',
                    'contractAddress' => '0x9876543210abcdef9876543210abcdef98765432',
                ]
            ]);

        $this->assertDatabaseHas('crowdsales', $payload);
    }

    /** @test */
    public function it_fails_to_store_crowdsale_with_invalid_data()
    {
        $payload = [
            'rate' => 'not-a-number',
            'deployerAddress' => '',
            'tokenAddress' => '',
            'contractAddress' => 'invalid-address',
        ];

        $response = $this->postJson('/api/crowdsale', $payload);

        $response->assertStatus(422)
            ->assertJson([
                'status' => false,
                'message' => 'Validation error',
                'details' => 'The rate field must be a number. (and 2 more errors)',
            ]);
    }


    /** @test */
    public function it_can_list_all_crowdsales()
    {
        Crowdsale::create([
            'rate' => 1.2,
            'deployerAddress' => '0xabcdefabcdefabcdefabcdefabcdefabcdefabcd',
            'tokenAddress' => '0x1234567890abcdef1234567890abcdef12345678',
            'contractAddress' => '0x9876543210abcdef9876543210abcdef98765432',
        ]);

        $response = $this->getJson('/api/crowdsale');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'rate',
                    'deployerAddress',
                    'tokenAddress',
                    'contractAddress',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
