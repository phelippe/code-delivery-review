<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminProductRequest;
use CodeDelivery\Repositories\CategoryRepository;

use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\ProductRepository;

class ProductsController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $productRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {

        $products = $this->productRepository->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->lists('name', 'id');

        return view('admin.products.create', compact('categories'));
    }

    public function store(AdminProductRequest $request)
    {

        $data = $request->all();
        $this->productRepository->create($data);

        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        $categories = $this->categoryRepository->lists('name', 'id');
        $product = $this->productRepository->find($id);

        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(AdminProductRequest $request, $id)
    {

        $data = $request->all();
        $this->productRepository->update($data, $id);

        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('admin.products.index');
    }
}
