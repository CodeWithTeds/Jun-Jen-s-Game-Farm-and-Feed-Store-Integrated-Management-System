<?php

namespace Database\Seeders;

use App\Models\Feed;
use App\Models\GameFowl;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSpendingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        
        if ($customers->isEmpty()) {
            $this->command->error('No customer users found. Please seed users first.');
            return;
        }

        // Available items to "purchase"
        $feeds = Feed::all();
        $gameFowls = GameFowl::all();

        if ($feeds->isEmpty() && $gameFowls->isEmpty()) {
            $this->command->error('No feeds or game fowls found. Please seed some items first.');
            return;
        }

        foreach ($customers as $customer) {
            $this->command->info('Seeding purchase history for ' . $customer->name . ' (' . $customer->email . ')...');

            // Create orders precisely between March 1 and March 29
            $startDate = Carbon::create(2026, 3, 1);
            $endDate = Carbon::create(2026, 3, 29);
            
            for ($date = clone $startDate; $date->lte($endDate); $date->addDay()) {
                // Guarantee at least 1 order per day for a full chart
                $ordersPerDay = rand(1, 3);
                
                for ($k = 0; $k < $ordersPerDay; $k++) {
                    $orderDate = (clone $date)->setHour(rand(8, 20))->setMinute(rand(0, 59));
                    
                    $order = Order::create([
                        'user_id' => $customer->id,
                        'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                        'total_amount' => 0, // Will update after items
                        'status' => 'completed',
                        'payment_status' => 'paid',
                        'shipping_address' => 'Customer Test Address, Seeding City',
                        'payment_method' => 'Cash on Delivery',
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);

                    $totalAmount = 0;
                    $itemCount = rand(1, 4);

                    for ($j = 0; $j < $itemCount; $j++) {
                        // Randomly pick a feed or game fowl
                        if (rand(0, 1) == 0 && $feeds->isNotEmpty()) {
                            $item = $feeds->random();
                            $price = $item->price ?? rand(500, 2000);
                            $qty = rand(1, 5);
                            
                            OrderItem::create([
                                'order_id' => $order->id,
                                'feed_id' => $item->id,
                                'price' => $price,
                                'quantity' => $qty,
                                'created_at' => $orderDate,
                                'updated_at' => $orderDate,
                            ]);
                            $totalAmount += ($price * $qty);
                        } else if ($gameFowls->isNotEmpty()) {
                            $item = $gameFowls->random();
                            $price = $item->price ?? rand(2000, 15000);
                            $qty = 1;

                            OrderItem::create([
                                'order_id' => $order->id,
                                'game_fowl_id' => $item->id,
                                'price' => $price,
                                'quantity' => $qty,
                                'created_at' => $orderDate,
                                'updated_at' => $orderDate,
                            ]);
                            $totalAmount += ($price * $qty);
                        }
                    }

                    $order->update(['total_amount' => $totalAmount]);
                }
            }
        }

        $this->command->info('Successfully seeded purchase history.');
    }
}
