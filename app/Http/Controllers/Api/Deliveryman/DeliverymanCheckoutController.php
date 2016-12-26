<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Events\GetLocationDeliveyman;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Models\Geo;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
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

        $orders = $this
          ->orderRepository
          ->skipPresenter(false)
          ->with(['items'])
          ->scopeQuery(function($query) use ($id){
                return $query->where('user_deliveryman_id', '=', $id);
            })
          ->paginate();

        return $orders;
    }

    public function show($id)
    {
        $id_deliveryman = Authorizer::getResourceOwnerId();

        return $this->orderRepository->skipPresenter(false)->getByIdAndDeliveryman($id, $id_deliveryman);
        /*return $this->orderRepository
          ->skipPresenter(false)
          ->with(['items'])
          ->scopeQuery(function($query) use ($id_deliveryman){
              return $query->where('user_deliveryman_id', '=', $id_deliveryman);
          })
          ->find($id);*/
    }

    public function updateStatus(Request $request, $id)
    {
        $id_deliveryman = Authorizer::getResourceOwnerId();

        return $this->orderService->updateStatus($id, $id_deliveryman, $request->get('status'));
    }

    public function geo(Request $request, Geo $geo, $id)
    {
        $id_deliveryman = Authorizer::getResourceOwnerId();

        $order = $this->orderRepository->getByIdAndDeliveryman($id, $id_deliveryman);
        $geo->lat = $request->get('lat');
        $geo->long = $request->get('long');

        event(new GetLocationDeliveyman($geo, $order));

        return $geo;
    }
}
