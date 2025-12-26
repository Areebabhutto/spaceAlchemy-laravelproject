<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request): View
    {
        $query = Order::with('user', 'items');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        $orders = $query->latest()->paginate(15);
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Show order details
     */
    public function show(Order $order): View
    {
        $order->load('user', 'items.product', 'items.package');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the order
     */
    public function edit(Order $order): View
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)
                       ->with('success', 'Order updated successfully');
    }

    /**
     * Delete an order
     */
    public function destroy(Order $order): RedirectResponse
    {
        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()->route('admin.orders.index')
                       ->with('success', "Order {$orderNumber} deleted successfully");
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $query = Order::with('items');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=orders_' . date('Y-m-d') . '.csv',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'Order Number',
                'Customer Name',
                'Email',
                'Phone',
                'Total Amount',
                'Status',
                'Payment Method',
                'Date',
                'Items Count'
            ]);

            // Data rows
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->total_amount,
                    $order->status,
                    $order->payment_method,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->items->count(),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
