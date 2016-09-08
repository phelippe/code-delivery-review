<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Models\Order;
use CodeDelivery\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{

    protected $skipPresenter = true;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getByIdAndDeliveryman($order_id, $deliveyman_id)
    {
        $result = $this->with(['client', 'items', 'cupom'])->findWhere([
            'id' => $order_id,
            'user_deliveryman_id' => $deliveyman_id
        ]);
        if ($result instanceof Collection) {
            //caso não use presenter
            $result = $result->first();
        } else {
            //caso use presenter
            if(isset($result['data']) && count($result['data']) == 1){
                // caso tenha dados
                //atribui o valor do data para a var result
                $result = [
                    'data' => $result['data'][0]
                ];
            } else {
                throw new ModelNotFoundException('Order não existe');
            }
        }
        return $result;
    }
}
