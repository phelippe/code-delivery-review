<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
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
        $id = Authorizer::getResourceOwnerId();
        $client_id = $this->userRepository->find($id)->client->id;

        $orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use ($client_id){
            return $query->where('client_id', '=', $client_id);
        })->paginate();

        return $orders;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $client_id = $this->userRepository->find($id)->client->id;

        $data['client_id'] = $client_id;

        $order = $this->orderService->create($data);

        $order = $this->orderRepository->with(['items'])->find($order->id);

        return $order;
    }

    public function show($id)
    {
        $order = $this->orderRepository->with(['client', 'items', 'cupom'])->find($id);

        $order->items->each(function($item){
            $item->product;
        });

        return $order;
    }
}
