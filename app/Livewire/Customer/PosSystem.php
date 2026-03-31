<?php

namespace App\Livewire\Customer;

use App\Services\CartService;
use App\Services\FeedService;
use App\Services\OrderService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class PosSystem extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $feedType = '';
    public $cart;
    public $loading = false;
    public $selectedFeed = null;
    public $selectedGameFowl = null;
    
    // Checkout fields
    public $paymentMethod = 'cash';
    public $amountTendered = null;
    public $note = '';
    public $showCheckoutModal = false;
    public $proofOfPayment;
    public $hasSavedAddress = false;
    public $showReceiptModal = false;
    public $latestOrder = null;
    public $paidAmount = 0;
    public $changeAmount = 0;

    // Shipping Address Fields
    public $location_name;
    public $contact_person;
    public $phone_number;
    public $address;
    public $city;
    public $province;
    public $postal_code;
    public $country = 'Philippines';
    public $location_type = 'Customer';
    public $is_default = true;
    public $remarks;

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
            if ($item->feed) {
                return $item->quantity * $item->feed->price;
            } elseif ($item->gameFowl) {
                return $item->quantity * $item->gameFowl->price;
            }
            return 0;
        });
    }

    public function getChangeProperty()
    {
        $amount = (float) $this->amountTendered;
        $subtotal = (float) $this->subtotal;

        if ($amount <= 0 || $amount < $subtotal) {
            return 0;
        }

        return $amount - $subtotal;
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

        $feed = \App\Models\Feed::find($feedId);
        if (!$feed || $feed->quantity <= 0) {
            $this->dispatch('notify', message: 'Item is out of stock.', type: 'error');
            return;
        }

        if ($this->cart) {
            $existingItem = $this->cart->items->where('feed_id', $feedId)->first();
            if ($existingItem && ($existingItem->quantity + 1) > $feed->quantity) {
                $this->dispatch('notify', message: 'Cannot add more. Exceeds available stock.', type: 'error');
                return;
            }
        }

        try {
            $this->cartService->addToCart(Auth::id(), $feedId, 1);
            $this->refreshCart();
            $this->dispatch('notify', message: 'Item added to cart.');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function addGameFowlToCart($gameFowlId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $this->cartService->addGameFowlToCart(Auth::id(), $gameFowlId);
            $this->refreshCart();
            $this->dispatch('notify', message: 'Game Fowl added to cart.');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function updateQuantity($itemId, $quantity)
    {
        $quantity = (int) $quantity;
        
        if ($quantity <= 0) {
            $this->removeFromCart($itemId);
            return;
        }

        $item = \App\Models\CartItem::find($itemId);
        if ($item && $item->feed && $quantity > $item->feed->quantity) {
            $this->dispatch('notify', message: 'Cannot update quantity. Exceeds available stock.', type: 'error');
            return;
        }
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

    public function viewFeed($feedId)
    {
        $this->selectedFeed = $this->feedService->getFeedById($feedId);
        $this->selectedGameFowl = null;
    }

    public function viewGameFowl($gameFowlId)
    {
        $this->selectedGameFowl = \App\Models\GameFowl::with(['medicalRecords', 'fightSchedules'])->find($gameFowlId);
        $this->selectedFeed = null;
    }

    public function closeFeedModal()
    {
        $this->selectedFeed = null;
        $this->selectedGameFowl = null;
    }

    public function openCheckoutModal()
    {
        if (!$this->cart || $this->cart->items->isEmpty()) {
            $this->dispatch('notify', message: 'Your cart is empty.', type: 'error');
            return;
        }

        $this->showCheckoutModal = true;
    }

    public function closeCheckoutModal()
    {
        $this->showCheckoutModal = false;
        $this->proofOfPayment = null;
        $this->resetValidation();
    }

    public function checkout()
    {
        $rules = [
            'paymentMethod' => 'required|string',
        ];

        if ($this->paymentMethod !== 'cash') {
            $rules['proofOfPayment'] = 'required|image|max:10240';
        } else {
            $rules['amountTendered'] = ['required', 'numeric', 'min:' . $this->subtotal];
        }

        $this->validate($rules, [
            'amountTendered.min' => 'The amount tendered must be at least ₱' . number_format($this->subtotal, 2) . '.'
        ]);

        try {
            $proofPath = null;
            if ($this->paymentMethod !== 'cash' && $this->proofOfPayment) {
                $proofPath = $this->proofOfPayment->store('proof-of-payments', 'public');
            }

            // For POS, we use a generic placeholder for address
            $fullAddress = "In-Store Transaction (POS)";

            $order = $this->orderService->checkout(
                Auth::id(), 
                $this->paymentMethod,
                $fullAddress,
                $this->note,
                $proofPath
            );

            $this->paidAmount = (float) $this->amountTendered;
            $this->changeAmount = $this->change;

            $this->refreshCart();
            $this->latestOrder = $order->load('items.feed', 'items.gameFowl');
            
            // Reset inputs
            $this->note = '';
            $this->paymentMethod = 'cash';
            $this->amountTendered = null;
            $this->showCheckoutModal = false;
            $this->showReceiptModal = true;
            
            $this->dispatch('notify', message: 'Order placed successfully! Order #' . $order->order_number);
            
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        $feeds = collect();
        $gameFowls = collect();

        if ($this->feedType === 'Game Fowl') {
            $gameFowls = \App\Models\GameFowl::where('sale_status', 'for_sale')
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('tag_id', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate(12);
        } else {
            $feeds = $this->feedService->getAllFeeds([
                'search' => $this->search,
                'is_displayed' => true,
                'feed_type' => $this->feedType
            ], 12);
        }

        $categories = $this->feedService->getFeedTypes();
        $categories[] = 'Game Fowl';

        return view('livewire.customer.pos-system', [
            'feeds' => $feeds,
            'gameFowls' => $gameFowls,
            'categories' => $categories
        ]);
    }
}
