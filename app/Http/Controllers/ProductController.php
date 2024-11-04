<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    protected $client;


    public function index()
{
    if ($this->client === null) {
        return response()->json(['error' => 'Neo4j client not initialized'], 500);
    }

    $query = 'MATCH (p:Product) RETURN p';
    $result = $this->client->run($query);

    $products = [];
    foreach ($result as $record) {
        $node = $record->get('p');
        $products[] = [
            'id' => $node->getProperty('id'),
            'name' => $node->getProperty('name'),
            'description' => $node->getProperty('description'),
            'price' => $node->getProperty('price'),
            'quantity' => $node->getProperty('quantity'),
        ];
    }

    return response()->json($products);
}


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Generate a unique ID for the product
        $id = uniqid();

        $query = 'CREATE (p:Product {id: $id, name: $name, description: $description, price: $price, quantity: $quantity}) RETURN p';
        $params = [
            'id' => $id,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ];

        $result = $this->client->run($query, $params);
        $node = $result->first()->get('p');

        $product = [
            'id' => $node->getProperty('id'),
            'name' => $node->getProperty('name'),
            'description' => $node->getProperty('description'),
            'price' => $node->getProperty('price'),
            'quantity' => $node->getProperty('quantity'),
        ];

        return response()->json($product, 201);
    }

    public function show($id)
    {
        $query = 'MATCH (p:Product {id: $id}) RETURN p';
        $result = $this->client->run($query, ['id' => $id]);

        if ($result->count() === 0) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $node = $result->first()->get('p');
        $product = [
            'id' => $node->getProperty('id'),
            'name' => $node->getProperty('name'),
            'description' => $node->getProperty('description'),
            'price' => $node->getProperty('price'),
            'quantity' => $node->getProperty('quantity'),
        ];

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        // Check if the product exists before attempting an update
        $query = 'MATCH (p:Product {id: $id}) RETURN p';
        $result = $this->client->run($query, ['id' => $id]);

        if ($result->count() === 0) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $query = 'MATCH (p:Product {id: $id}) 
                  SET p.name = $name, p.description = $description, p.price = $price, p.quantity = $quantity 
                  RETURN p';
        $params = [
            'id' => $id,
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ];

        $result = $this->client->run($query, $params);
        $node = $result->first()->get('p');

        $product = [
            'id' => $node->getProperty('id'),
            'name' => $node->getProperty('name'),
            'description' => $node->getProperty('description'),
            'price' => $node->getProperty('price'),
            'quantity' => $node->getProperty('quantity'),
        ];

        return response()->json($product);
    }

    public function destroy($id)
    {
        // Check if the product exists before attempting deletion
        $result = $this->client->run('MATCH (p:Product {id: $id}) RETURN p', ['id' => $id]);

        if ($result->count() === 0) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $query = 'MATCH (p:Product {id: $id}) DETACH DELETE p';
        $this->client->run($query, ['id' => $id]);

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
