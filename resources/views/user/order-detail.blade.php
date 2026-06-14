@extends('layouts.app') @section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Order Receipt #{{ $order->id }}</h1>
    
    <div class="bg-white p-6 rounded shadow-md">
        <h3 class="font-bold text-lg border-b pb-2 mb-4">Customer Details</h3>
        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Address:</strong> {{ $order->address }}</p>
        <p><strong>Status:</strong> <span class="uppercase font-bold text-blue-600">{{ $order->status }}</span></p>

        <h3 class="font-bold text-lg border-b pb-2 mt-6 mb-4">Order Items</h3>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->book->title ?? 'Unknown Book' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Shipping:</strong> ${{ number_format($order->shipping, 2) }}</p>
            <h2 class="text-xl font-bold mt-2">Grand Total: ${{ number_format($order->total, 2) }}</h2>
        </div>
    </div>
    
    <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-blue-500 hover:underline">&larr; Back to Dashboard</a>
</div>
@endsection