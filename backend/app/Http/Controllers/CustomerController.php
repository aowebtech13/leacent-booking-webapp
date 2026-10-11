<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Store a new customer submitted from the dashboard create-customers form.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'shop_location' => ['required', 'string', 'max:255'],
            'shop_notes' => ['required', 'string'],
        ]);

        /** @var \App\Models\User|null $user */
        $user = $request->user();

        $customer = Customer::create([
            'user_id' => $user?->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'phone' => $data['phone'],
            'shop_location' => $data['shop_location'],
            'shop_notes' => $data['shop_notes'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer created successfully.',
            'data' => $customer,
        ], 201);
    }

    /**
     * List customers belonging to the authenticated user.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        $query = Customer::query()->latest();

        if ($user) {
            $query->where('user_id', $user->id);
        }

        $customers = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Customers retrieved successfully.',
            'data' => $customers,
        ]);
    }

    /**
     * Update an existing customer.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'shop_location' => ['required', 'string', 'max:255'],
            'shop_notes' => ['required', 'string'],
        ]);

        $customer->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'phone' => $data['phone'],
            'shop_location' => $data['shop_location'],
            'shop_notes' => $data['shop_notes'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully.',
            'data' => $customer,
        ]);
    }

    /**
     * Delete a customer.
     */
    public function destroy(Request $request, Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.',
        ]);
    }
}
