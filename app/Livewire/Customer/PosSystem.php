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
    
    // Checkout fields
    public $paymentMethod = 'cash';
    public $note = '';
    public $showCheckoutModal = false;
    public $proofOfPayment;
    public $hasSavedAddress = false;

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

    public function viewFeed($feedId)
    {
        $this->selectedFeed = $this->feedService->getFeedById($feedId);
    }

    public function closeFeedModal()
    {
        $this->selectedFeed = null;
    }

    public function openCheckoutModal()
    {
        if (!$this->cart || $this->cart->items->isEmpty()) {
            $this->dispatch('notify', message: 'Your cart is empty.', type: 'error');
            return;
        }

        // Check for existing shipping address
        $userId = Auth::id();
        $user = $userId ? \App\Models\User::find($userId) : null;

        if ($user) {
            $defaultAddress = $user->shippingAddresses()->where('is_default', true)->first();
            
            if ($defaultAddress) {
                $this->hasSavedAddress = true;
                $this->location_name = $defaultAddress->location_name;
                $this->contact_person = $defaultAddress->contact_person;
                $this->phone_number = $defaultAddress->phone_number;
                $this->address = $defaultAddress->address;
                $this->city = $defaultAddress->city;
                $this->province = $defaultAddress->province;
                $this->postal_code = $defaultAddress->postal_code;
                $this->country = $defaultAddress->country;
                $this->location_type = $defaultAddress->location_type;
                $this->remarks = $defaultAddress->remarks;
            } else {
                $this->hasSavedAddress = false;
                // Pre-fill contact person and phone from user profile if available
                $this->contact_person = $user->name;
                $this->phone_number = $user->phone_number;
            }
        }

        $this->showCheckoutModal = true;
    }

    public function closeCheckoutModal()
    {
        $this->showCheckoutModal = false;
        $this->proofOfPayment = null;
        $this->resetValidation();
        // Reset address fields if not saved
        if (!$this->hasSavedAddress) {
            $this->reset(['location_name', 'contact_person', 'phone_number', 'address', 'city', 'province', 'postal_code', 'country', 'location_type', 'is_default', 'remarks']);
        }
    }

    public function checkout()
    {
        $rules = [
            'paymentMethod' => 'required|string',
            'proofOfPayment' => 'nullable|image|max:10240',
        ];

        if (!$this->hasSavedAddress) {
            $rules = array_merge($rules, [
                'location_name' => 'required|string|max:255',
                'contact_person' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
                'country' => 'required|string|max:100',
            ]);
        }

        if ($this->paymentMethod !== 'cash') {
            $rules['proofOfPayment'] = 'required|image|max:10240';
        }

        $this->validate($rules);

        try {
            // Save address if new
            if (!$this->hasSavedAddress) {
                $user = \App\Models\User::find(Auth::id());
                if ($user) {
                    $user->shippingAddresses()->create([
                        'location_name' => $this->location_name,
                        'contact_person' => $this->contact_person,
                        'phone_number' => $this->phone_number,
                        'address' => $this->address,
                        'city' => $this->city,
                        'province' => $this->province,
                        'postal_code' => $this->postal_code,
                        'country' => $this->country,
                        'location_type' => $this->location_type,
                        'is_default' => $this->is_default,
                        'remarks' => $this->remarks,
                        'status' => 'Active'
                    ]);
                }
            }

            $proofPath = null;
            if ($this->paymentMethod !== 'cash' && $this->proofOfPayment) {
                $proofPath = $this->proofOfPayment->store('proof-of-payments', 'public');
            }

            // Format full address for order record
            $fullAddress = "{$this->contact_person} ({$this->phone_number})\n{$this->address}, {$this->city}, {$this->province} {$this->postal_code}, {$this->country}\n{$this->location_name}";

            $order = $this->orderService->checkout(
                Auth::id(), 
                $this->paymentMethod,
                $fullAddress,
                $this->note,
                $proofPath
            );

            $this->refreshCart();
            $this->dispatch('notify', message: 'Order placed successfully! Order #' . $order->order_number);
            
            // Reset inputs
            $this->note = '';
            $this->paymentMethod = 'cash';
            $this->closeCheckoutModal();
            
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
