<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class DeliverymanCheckoutController extends Controller
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

        $orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use ($id){
            return $query->where('user_deliveryman_id', '=', $id);
        })->paginate();

        return $orders;
    }

    public function show($id)
    {
        $id_deliveryman = Authorizer::getResourceOwnerId();

        return $this->orderRepository->getByIdAndDeliveryman($id, $id_deliveryman);
    }

    public function updateStatus(Request $request, $id)
    {
        $id_deliveryman = Authorizer::getResourceOwnerId();

        #dd($request->get('status'), $id);
        $order = $this->orderService->updateStatus($id, $id_deliveryman, $request->get('status'));
        #dd($order);

        if($order instanceof Order){
            return $order;
        }

        abort(400, 'Order não encontrada');
    }
}
