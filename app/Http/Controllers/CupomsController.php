<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminClientRequest;

use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\CupomRepository;

class CupomsController extends Controller
{


    /**
     * @var CupomRepository
     */
    private $cupomRepository;

    public function __construct(CupomRepository $cupomRepository)
    {

        $this->cupomRepository = $cupomRepository;
    }

    public function index()
    {
        $cupoms = $this->cupomRepository->paginate();

        return view('admin.cupoms.index', compact('cupoms'));
    }

    public function create()
    {
        return view('admin.cupoms.create');
    }

    public function store(AdminCategoryRequest $request)
    {

        $data = $request->all();
        $this->categoryRepository->create($data);

        return redirect()->route('admin.cupoms.index');
    }

}
