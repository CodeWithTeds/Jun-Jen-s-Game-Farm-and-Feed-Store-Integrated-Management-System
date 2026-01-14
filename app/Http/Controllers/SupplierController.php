<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index(Request $request)
    {
        $suppliers = $this->supplierService->getAllSuppliers($request->all());
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(StoreSupplierRequest $request)
    {
        $this->supplierService->createSupplier($request->validated());
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function show($id)
    {
        $supplier = $this->supplierService->getSupplierById($id);
        return view('suppliers.show', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = $this->supplierService->getSupplierById($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(UpdateSupplierRequest $request, $id)
    {
        $this->supplierService->updateSupplier($id, $request->validated());
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $this->supplierService->deleteSupplier($id);
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
