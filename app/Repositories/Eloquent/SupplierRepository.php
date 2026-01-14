<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Supplier::query();

        if (isset($filters['search']) && $filters['search'] !== '') {
            $query->where(function($q) use ($filters) {
                $q->where('supplier_name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('contact_person', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['supplier_type']) && $filters['supplier_type'] !== '') {
            $query->where('supplier_type', $filters['supplier_type']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById($id): ?Supplier
    {
        return Supplier::find($id);
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update($id, array $data): bool
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            return $supplier->update($data);
        }
        return false;
    }

    public function delete($id): bool
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            return $supplier->delete();
        }
        return false;
    }
}
