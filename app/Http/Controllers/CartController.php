<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private const CART_KEY = 'cart';
    private const LAST_CHECKOUT_KEY = 'last_checkout';

    public function index()
    {
        $cart = $this->getCart();
        $summary = $this->buildSummary($cart);

        return view('cart.index', [
            'cartItems' => array_values($cart),
            'totalItems' => $summary['totalItems'],
            'subtotal' => $summary['subtotal'],
        ]);
    }

    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::with('umkm')->findOrFail($productId);

        if ($product->stock < 1) {
            return back()->with('error', 'Stok produk sedang habis.');
        }

        $quantityToAdd = (int) ($request->input('quantity', 1));
        $cart = $this->getCart();

        if (!isset($cart[$product->id])) {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'umkm_id' => $product->umkm_id,
                'umkm_name' => $product->umkm->name,
                'name' => $product->name,
                'price' => (int) $product->price,
                'stock' => (int) $product->stock,
                'image' => $product->image,
                'quantity' => 0,
            ];
        }

        $newQty = $cart[$product->id]['quantity'] + $quantityToAdd;

        if ($newQty > $product->stock) {
            $newQty = (int) $product->stock;
        }

        $cart[$product->id]['quantity'] = $newQty;
        $cart[$product->id]['stock'] = (int) $product->stock;

        $this->saveCart($cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = $this->getCart();

        if (!isset($cart[$productId])) {
            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang.');
        }

        $quantity = (int) $request->input('quantity');

        if ($quantity === 0) {
            unset($cart[$productId]);
            $this->saveCart($cart);

            return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
        }

        $product = Product::find($productId);

        if (!$product || $product->stock < 1) {
            unset($cart[$productId]);
            $this->saveCart($cart);

            return redirect()->route('cart.index')->with('error', 'Produk sudah tidak tersedia.');
        }

        if ($quantity > $product->stock) {
            $quantity = (int) $product->stock;
        }

        $cart[$productId]['quantity'] = $quantity;
        $cart[$productId]['stock'] = (int) $product->stock;

        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function remove($productId)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->saveCart($cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $cart = $this->syncCartWithLatestStock($this->getCart());
        $summary = $this->buildSummary($cart);

        if ($summary['totalItems'] < 1) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        return view('cart.checkout', [
            'cartItems' => array_values($cart),
            'totalItems' => $summary['totalItems'],
            'subtotal' => $summary['subtotal'],
        ]);
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,transfer',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = $this->syncCartWithLatestStock($this->getCart());
        $summary = $this->buildSummary($cart);

        if ($summary['totalItems'] < 1) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong atau stok produk sudah habis.');
        }

        $orderCode = 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

        $order = DB::transaction(function () use ($request, $cart, $summary, $orderCode) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => $orderCode,
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'total_items' => $summary['totalItems'],
                'subtotal' => $summary['subtotal'],
                'status' => 'baru',
                'checked_out_at' => now(),
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'umkm_id' => $item['umkm_id'],
                    'product_name' => $item['name'],
                    'price' => (int) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'subtotal' => (int) $item['price'] * (int) $item['quantity'],
                ]);
            }

            return $order;
        });

        session()->put(self::LAST_CHECKOUT_KEY, [
            'order_code' => $order->order_code,
            'customer_name' => $order->customer_name,
            'phone' => $order->phone,
            'address' => $order->address,
            'payment_method' => $order->payment_method,
            'notes' => $order->notes,
            'items' => array_values($cart),
            'total_items' => $order->total_items,
            'subtotal' => $order->subtotal,
            'checkout_at' => optional($order->checked_out_at)->format('d M Y, H:i'),
        ]);

        session()->forget(self::CART_KEY);

        return redirect()->route('cart.success');
    }

    public function success()
    {
        $checkout = session()->get(self::LAST_CHECKOUT_KEY);

        if (!$checkout) {
            return redirect()->route('cart.index');
        }

        return view('cart.success', compact('checkout'));
    }

    private function getCart(): array
    {
        return session()->get(self::CART_KEY, []);
    }

    private function saveCart(array $cart): void
    {
        session()->put(self::CART_KEY, $cart);
    }

    private function buildSummary(array $cart): array
    {
        $subtotal = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $qty = (int) $item['quantity'];
            $price = (int) $item['price'];

            $subtotal += $price * $qty;
            $totalItems += $qty;
        }

        return [
            'subtotal' => $subtotal,
            'totalItems' => $totalItems,
        ];
    }

    private function syncCartWithLatestStock(array $cart): array
    {
        if (empty($cart)) {
            return [];
        }

        $productIds = array_keys($cart);
        $products = Product::with('umkm')->whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as $productId => $item) {
            if (!isset($products[$productId])) {
                unset($cart[$productId]);
                continue;
            }

            $product = $products[$productId];

            if ($product->stock < 1) {
                unset($cart[$productId]);
                continue;
            }

            $newQty = min((int) $item['quantity'], (int) $product->stock);

            $cart[$productId]['quantity'] = $newQty;
            $cart[$productId]['stock'] = (int) $product->stock;
            $cart[$productId]['price'] = (int) $product->price;
            $cart[$productId]['name'] = $product->name;
            $cart[$productId]['image'] = $product->image;
            $cart[$productId]['umkm_name'] = $product->umkm->name;
            $cart[$productId]['umkm_id'] = $product->umkm_id;
        }

        $this->saveCart($cart);

        return $cart;
    }
}
