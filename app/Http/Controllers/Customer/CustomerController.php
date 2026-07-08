<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class CustomerController extends Controller
{
    public function index(Request $request){
        $customers=User::role('customer')
            ->when($request->filled('search'),function($query) use ($request){
                $search=$request->string('search');
                $query->where(function($q) use ($search){
                    $q->where('name','like','%{$search}%');
                });
            })->when($request->filled('status'),function($query) use($request){
                $query->where('is_active',$request->get('status') === 'active');
            })
            ->orderBy('name')->paginate(10)->withQueryString();
            return view('admin.customers.index', compact('customers'));
    }

    public function edit(User $customer){
        $permissions=Permission::orderBy('name')->get();
        return view('admin.customers.edit', compact('customer', 'permissions'));
    }

    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $customer->id],
        ]);
        $customer->update($validated);
        return redirect()
            ->route('admin.customers.edit', $customer)
            ->with('success', __('Customer updated successfully.'));
    }

    public function toggleStatus(User $customer){
        $customer->update(['is_active' => ! $customer->is_active]);
        return back()->with(
            'success',
            $customer->is_active
                ? __('Customer unblocked successfully.')
                : __('Customer blocked successfully.')
        );
    }

    public function updatePermissions(Request $request, User $customer)
    {
        $validated = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);
 
        $customer->syncPermissions($validated['permissions'] ?? []);
 
        return redirect()
            ->route('admin.customers.edit', $customer)
            ->with('success', __('Permissions updated successfully.'));
    }
}
