<?php

namespace App\Livewire\Customer;

use App\Services\CartService;
use App\Services\FeedService;
use App\Services\OrderService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PosSystem extends Component
{
    use WithPagination;

    public $search = '';
    public $feedType = '';
    public $cart;
    public $loading = false;
    
    // Checkout fields
    public $paymentMethod = 'cash';
    public $note = '';

    protected $cartService;
    protected $feedService;
    protected $orderService;

    public function boot(
        CartService $cartService,
        FeedService $feedService,
        OrderService $orderService
    ) {
        $this->cartService = $cartService;
        $this->feedService = $feedService;
        $this->orderService = $orderService;
    }

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        if (Auth::check()) {
            $this->cart = $this->cartService->getCart(Auth::id());
        }
    }

    public function getSubtotalProperty()
    {
        if (!$this->cart || !$this->cart->items) {
            return 0;
        }
        return $this->cart->items->sum(function($item) {
            return $item->quantity * $item->feed->price;
        });
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function addToCart($feedId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $this->cartService->addToCart(Auth::id(), $feedId, 1);
            $this->refreshCart();
            $this->dispatch('notify', message: 'Item added to cart.');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function updateQuantity($itemId, $quantity)
    {
        try {
            $this->cartService->updateItemQuantity(Auth::id(), $itemId, $quantity);
            $this->refreshCart();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function removeFromCart($itemId)
    {
        try {
            $this->cartService->removeItem(Auth::id(), $itemId);
            $this->refreshCart();
            $this->dispatch('notify', message: 'Item removed from cart.');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function checkout()
    {
        try {
            $order = $this->orderService->checkout(Auth::id(), $this->paymentMethod, $this->note);
            $this->refreshCart();
            $this->dispatch('notify', message: 'Order placed successfully! Order #' . $order->order_number);
            
            // Optional: Redirect to order summary or clear inputs
            $this->note = '';
            $this->paymentMethod = 'cash';
            
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        $feeds = $this->feedService->getAllFeeds([
            'search' => $this->search,
            'is_displayed' => true,
            'feed_type' => $this->feedType
        ], 12);

        $categories = $this->feedService->getFeedTypes();

        return view('livewire.customer.pos-system', [
            'feeds' => $feeds,
            'categories' => $categories
        ]);
    }
}
