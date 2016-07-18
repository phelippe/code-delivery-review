<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminCategoryRequest;
use CodeDelivery\Repositories\CategoryRepository;

use CodeDelivery\Http\Requests;

class CategoriesController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {

        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {

        $categories = $this->categoryRepository->paginate(5);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(AdminCategoryRequest $request)
    {

        $data = $request->all();
        $this->categoryRepository->create($data);

        return redirect()->route('admin.categories.index');
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(AdminCategoryRequest $request, $id)
    {

        $data = $request->all();
        $this->categoryRepository->update($data, $id);

        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        $this->categoryRepository->delete($id);

        return redirect()->route('admin.categories.index');
    }
}
