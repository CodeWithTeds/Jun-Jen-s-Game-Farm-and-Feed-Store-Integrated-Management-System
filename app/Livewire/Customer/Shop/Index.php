<?php

namespace App\Livewire\Customer\Shop;

use Livewire\Component;
use App\Models\GameFowl;
use App\Services\CartService;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sort = 'latest';

    public function addToCart(int $gameFowlId, CartService $cartService)
    {
        try {
            $cartService->addGameFowlToCart(\Illuminate\Support\Facades\Auth::id(), $gameFowlId);
            $this->dispatch('cart-updated'); // Emit event to update cart counter if exists
            session()->flash('success', 'Game fowl added to cart successfully.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $gameFowls = GameFowl::query()
            ->where('sale_status', 'for_sale')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('tag_id', 'like', '%' . $this->search . '%');
            })
            ->when($this->sort === 'latest', fn ($q) => $q->latest())
            ->when($this->sort === 'price_asc', fn ($q) => $q->orderBy('price', 'asc'))
            ->when($this->sort === 'price_desc', fn ($q) => $q->orderBy('price', 'desc'))
            ->paginate(12);

        return view('livewire.customer.shop.index', [
            'gameFowls' => $gameFowls
        ]);
    }
}
