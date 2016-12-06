<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
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
     * @var OrderService
     */
    private $orderService;

    private $with = ['client', 'cupom', 'items'];

   public function __construct(OrderRepository $orderRepository,
                                UserRepository $userRepository,
                                OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $client_id = $this->userRepository->find($id)->client->id;

        $orders = $this->orderRepository
            ->skipPresenter(false)
            ->with($this->with)
            ->scopeQuery(function($query) use ($client_id){
                return $query->where('client_id', '=', $client_id);
        })->paginate();

        return $orders;
    }

    public function store(Requests\CheckoutRequest $request)
    {

        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $client_id = $this->userRepository->find($id)->client->id;

        $data['client_id'] = $client_id;

        $order = $this->orderService->create($data);

        #$order = $this->orderRepository->with(['items'])->find($order->id);

        return $this->orderRepository
            ->skipPresenter(false)
            ->with($this->with)
            ->find($order->id);
    }

    public function show($id)
    {
        return $this->orderRepository
            ->skipPresenter(false)
            ->with(['client', 'items', 'cupom'])
            ->find($id);
    }
}
