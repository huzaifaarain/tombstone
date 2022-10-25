<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Font;
use App\Models\Icon;
use App\Models\Order;
use App\Models\TextColor;
use App\Models\Tombstone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    public function test_get_all_orders()
    {
        $response = $this->get(
            '/api/order',
            [],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_post_order_with_success()
    {
        Storage::fake('avatars');
        $tombstone = Tombstone::inRandomOrder()->first();
        $font = Font::inRandomOrder()->first();
        $textColor = TextColor::inRandomOrder()->first();
        $icon = Icon::inRandomOrder()->first();

        $response = $this->postJson(
            '/api/order',
            [
                'image' => UploadedFile::fake()->create('avatar.png'),
                'tombstone' => $tombstone->id,
                'name' => 'Dummy Name',
                'font' => $font->id,
                'textColor' => $textColor->id,
                'dateOfBirth' => Carbon::now()->toDateString(),
                'deathDate' => Carbon::now()->toDateString(),
                'icon' => $icon->id,
                'price' => rand(0,10000),
            ],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_post_order_with_unprocessable_entity()
    {
        $response = $this->postJson(
            '/api/order',
            [
                'image' => '',
                'tombstone' => '',
                'name' => 'Dummy Name',
                'font' => 1,
                'textColor' => 3,
                'dateOfBirth' => Carbon::now()->toDateString(),
                'deathDate' => Carbon::now()->toDateString(),
                'icon' => 4,
                'price' => rand(0,10000),
            ],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_put_order_with_success()
    {
        $orderId = Order::inRandomOrder()->first()?->id;
        if(!$orderId){
            $this->assertFalse(true,"No order available for testing.");
        }
        $tombstone = Tombstone::inRandomOrder()->first();
        $font = Font::inRandomOrder()->first();
        $textColor = TextColor::inRandomOrder()->first();
        $icon = Icon::inRandomOrder()->first();

        $response = $this->putJson(
            "/api/order/$orderId",
            [
                'tombstone' => $tombstone->id,
                'name' => 'Dummy Name',
                'font' => $font->id,
                'textColor' => $textColor->id,
                'dateOfBirth' => Carbon::now()->toDateString(),
                'deathDate' => Carbon::now()->toDateString(),
                'icon' => $icon->id,
                'price' => rand(0,10000),
            ],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_put_order_with_fail()
    {
        $orderId = -1;
        $tombstone = Tombstone::inRandomOrder()->first();
        $font = Font::inRandomOrder()->first();
        $textColor = TextColor::inRandomOrder()->first();
        $icon = Icon::inRandomOrder()->first();

        $response = $this->putJson(
            "/api/order/$orderId",
            [
                'tombstone' => $tombstone->id,
                'name' => 'Dummy Name',
                'font' => $font->id,
                'textColor' => $textColor->id,
                'dateOfBirth' => Carbon::now()->toDateTimeString(),
                'deathDate' => Carbon::now()->toDateTimeString(),
                'icon' => $icon->id,
                'price' => rand(0,10000),
            ],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_get_order_by_id_with_success()
    {
        $orderId = Order::inRandomOrder()->first()?->id;
        if(!$orderId){
            $this->assertFalse(true,"No order available for testing.");
        }
        $response = $this->get(
            "/api/order/$orderId",
            [],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_get_order_by_id_with_fail()
    {
        $id = -1;
        $response = $this->get(
            "/api/order/$id",
            [],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_order_by_id_with_success()
    {
        $orderId = Order::inRandomOrder()->first()?->id;
        if(!$orderId){
            $this->assertFalse(true,"No order available for testing.");
        }
        $response = $this->delete(
            "/api/order/$orderId",
            [],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_delete_order_by_id_with_fail()
    {
        $orderId = -1;
        $response = $this->delete(
            "/api/order/$orderId",
            [],
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
