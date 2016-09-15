<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{


    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderRepository $orderRepository,
                                UserRepository $userRepository,
                                ProductRepository $productRepository,
                                OrderService $orderService)
    {

        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        #dd($this->userRepository->find(Auth::user()->id)->client->id);
        $client_id = $this->userRepository->find(Auth::user()->id)->client->id;
        $orders = $this->orderRepository->scopeQuery(function($query) use ($client_id){
            return $query->where('client_id', '=', $client_id);
        })->paginate();

        return view('customer.order.index', compact('orders'));
    }
    
    public function create()
    {
        $products = $this->productRepository->lists('name', 'id');

        return view('customer.order.create', compact('products'));
    }

    public function store(Requests\CheckoutRequest $request)
    {
        $data = $request->all();
        $client_id = $this->userRepository->find(Auth::user()->id)->client->id;

        $data['client_id'] = $client_id;

        $this->orderService->create($data);

        return redirect()->route('customer.order.index');
    }
}
