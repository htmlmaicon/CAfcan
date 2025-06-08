<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Middleware para proteger todas as rotas (apenas admin pode acessar)
    public function __construct()
    {
        $this->middleware(['auth', 'can:isAdmin']);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // Validação reforçada
        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpeg,png|max:2048',
            'price' => ['required', 'regex:/^\d{1,6},\d{2}$/'],
            'description' => 'required|string|max:500',
            'category' => 'required|in:congelado,panificado,fruta,verdura',
            'quantity' => 'required|integer|min:0|max:99999',
        ]);

        // Sanitização dos dados
        $name = strip_tags($request->name);
        $description = strip_tags($request->description);

        // Converte preço para float (ex: "12,90" => 12.90)
        $price = str_replace(',', '.', $request->price);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Garante nome único para o arquivo
            $imageName = uniqid('product_', true) . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('products', $imageName, 'public');
        }

        Product::create([
            'name' => $name,
            'image' => $imagePath,
            'price' => $price,
            'description' => $description,
            'category' => $request->category,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validação reforçada
        $request->validate([
            'name' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'price' => ['required', 'regex:/^\d{1,6},\d{2}$/'],
            'description' => 'required|string|max:500',
            'category' => 'required|in:congelado,panificado,fruta,verdura',
            'quantity' => 'required|integer|min:0|max:99999',
        ]);

        // Sanitização dos dados
        $name = strip_tags($request->name);
        $description = strip_tags($request->description);

        // Converte preço para float (ex: "12,90" => 12.90)
        $price = str_replace(',', '.', $request->price);

        if ($request->hasFile('image')) {
            // Exclui imagem antiga se houver
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imageName = uniqid('product_', true) . '.' . $request->file('image')->getClientOriginalExtension();
            $product->image = $request->file('image')->storeAs('products', $imageName, 'public');
        }

        $product->update([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'category' => $request->category,
            'image' => $product->image,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Exclui a imagem se houver
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }
}