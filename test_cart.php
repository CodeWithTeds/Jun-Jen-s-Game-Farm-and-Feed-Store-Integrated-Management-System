<?php

use App\Models\User;
use App\Models\Feed;
use App\Services\CartService;
use App\Repositories\Eloquent\CartRepository;
use App\Repositories\Eloquent\FeedRepository;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // 1. Create a test user
    $user = User::firstOrCreate(
        ['email' => 'test@example.com'],
        ['name' => 'Test User', 'password' => bcrypt('password'), 'role' => 'customer']
    );

    echo "User ID: " . $user->id . "\n";

    // 2. Create a test feed if not exists
    $feed = Feed::first();
    if (!$feed) {
        $feed = Feed::create([
            'feed_name' => 'Test Feed',
            'feed_type' => 'Appetizer',
            'brand' => 'Test Brand',
            'quantity' => 100,
            'price' => 10.50,
            'unit' => 'kg',
            'batch_number' => 'BATCH001',
            'expiration_date' => now()->addYear(),
            'supplier' => 'Test Supplier',
            'date_received' => now(),
            'reorder_level' => 10,
            'storage_location' => 'A1',
            'status' => 'active',
            'is_displayed' => true,
        ]);
    }

    echo "Feed ID: " . $feed->id . "\n";
    echo "Feed Quantity: " . $feed->quantity . "\n";

    // 3. Initialize Service
    $cartRepo = new CartRepository();
    $feedRepo = new FeedRepository();
    $cartService = new CartService($cartRepo, $feedRepo);

    // 4. Test Add to Cart
    echo "Adding to cart...\n";
    $cart = $cartService->addToCart($user->id, $feed->id, 1);
    
    echo "Cart ID: " . $cart->id . "\n";
    echo "Items count: " . $cart->items->count() . "\n";
    
    if ($cart->items->count() > 0) {
        echo "Item added successfully.\n";
        $item = $cart->items->first();
        echo "Item Feed Name: " . $item->feed->feed_name . "\n";
    } else {
        echo "FAILED: Cart is empty.\n";
    }

    // 5. Test Update Quantity
    echo "Updating quantity...\n";
    $cart = $cartService->updateItemQuantity($user->id, $cart->items->first()->id, 2);
    echo "New Quantity: " . $cart->items->first()->quantity . "\n";

    // 6. Test Remove Item
    echo "Removing item...\n";
    $cart = $cartService->removeItem($user->id, $cart->items->first()->id);
    echo "Items count after removal: " . $cart->items->count() . "\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
