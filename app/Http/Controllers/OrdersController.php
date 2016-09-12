<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminOrderRequest;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;

use CodeDelivery\Http\Requests;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function index(){

        $orders = $this->orderRepository->paginate();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->orderRepository->find($id);

        #$clients = $this->clientRepository->lists('name', 'id');

        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $list_status = [
            0=>'Pendente',
            1=>'A caminho',
            2=>'Entregue',
            3=>'Cancelado',
        ];

        $order = $this->orderRepository->find($id);
        $deliveryman = $this->userRepository->getDeliverymen();

        #dd($order,$deliveryman);

        return view('admin.orders.edit', compact('order', 'deliveryman', 'list_status'));
    }

    public function update(AdminOrderRequest $request, $id)
    {
        $data = $request->all();
        $this->orderRepository->update($data, $id);
        return redirect()->route('admin.orders.show', $id);
    }
}
