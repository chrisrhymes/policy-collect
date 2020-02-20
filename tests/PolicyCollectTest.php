<?php

namespace Tests;

use ChrisRhymes\PolicyCollect\Tests\Models\Order;
use ChrisRhymes\PolicyCollect\Tests\TestCase;
use ChrisRhymes\PolicyCollect\Tests\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyCollectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function policy_collection_method_available()
    {
        $collection = collect([])->policy();
        $this->assertEmpty($collection);
    }

    /** @test */
    public function policy_collection_on_array()
    {
        try {
            $collection = collect(['test', 'test2'])->policy();
        } catch (\Exception $e) {
            $this->assertEquals("Attempt to assign property 'can' of non-object", $e->getMessage());
            return;
        }

        $this->fail("Should have thrown exception");
    }

    /** @test */
    public function user_matching_order_user_allowed()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        factory(Order::class, 2)->create([
            'user_id' => $user->id,
        ]);

        $orders = Order::get()->policy();

        foreach($orders as $order) {
            $this->assertTrue($order->can->view);
            $this->assertTrue($order->can->update);
            $this->assertTrue($order->can->delete);
            $this->assertFalse($order->can->restore);
            $this->assertFalse($order->can->forceDelete);
        }
    }

    /** @test */
    public function user_not_matching_order_user_not_allowed()
    {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $this->be($user);

        factory(Order::class, 2)->create([
            'user_id' => $otherUser->id,
        ]);

        $orders = Order::get()->policy();

        foreach($orders as $order) {
            $this->assertFalse($order->can->view);
            $this->assertFalse($order->can->update);
            $this->assertFalse($order->can->delete);
        }
    }

    /** @test */
    public function mix_of_order_owners()
    {
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $this->be($user);

        factory(Order::class)->create([
            'user_id' => $user->id,
        ]);
        factory(Order::class)->create([
            'user_id' => $otherUser->id,
        ]);

        $orders = Order::orderBy('id', 'asc')->get()->policy();

        // Order belonging to user
        $this->assertTrue($orders[0]->can->view);
        $this->assertTrue($orders[0]->can->update);
        $this->assertTrue($orders[0]->can->delete);

        // Order belonging to other user
        $this->assertFalse($orders[1]->can->view);
        $this->assertFalse($orders[1]->can->update);
        $this->assertFalse($orders[1]->can->delete);
    }

    /** @test */
    public function custom_additional_policy_method_evaluated()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        factory(Order::class)->create([
            'user_id' => $user->id
        ]);

        $orders = Order::get()->policy(['customMethod']);

        $this->assertTrue($orders[0]->can->customMethod);
    }
}