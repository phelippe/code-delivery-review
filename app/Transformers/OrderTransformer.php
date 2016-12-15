<?php

namespace CodeDelivery\Transformers;

//use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    #protected $defaultIncludes = ['cupom', 'items'];
    protected $availableIncludes = ['cupom', 'items', 'client', 'deliveryman'];

    #protected $availableIncludes = [''];

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
            'total'         => (float) $model->total,
            'status'         => $this->getStatusName($model->status),
            'items'      => $model->items,
            'names'      => $this->getArrayProductNames($model->items),

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function getArrayProductNames(Collection $items)
    {
        $names = [];
        foreach($items as $item){
            $names[] = $item->product->name;
        }
        return $names;
    }

    protected function getStatusName($idStatus)
    {
        $statusName = "";
        switch($idStatus){
            case 0: {
                $statusName = "Aguardando pagamento";
                break;
            }
            case 1: {
                $statusName = "Saiu para entrega";
                break;
            }
            case 2: {
                $statusName = "Entregue";
                break;
            }
            case 3: {
                $statusName = "Cancelado";
                break;
            }
            case 4: {
                $statusName = "OUTRO - Contate o suporte";
                break;
            }
        }
        return $statusName;
    }

    public function includeCupom(Order $model){
        if(!$model->cupom){
            return null;
        }
        return $this->item($model->cupom, new CupomTransformer());
    }

    public function includeItems(Order $model){
        return $this->collection($model->items, new OrderItemTransformer());
    }

    public function includeClient(Order $model){
        return $this->item($model->client, new ClientTransformer());
    }

    public function includeDeliveryman(Order $model){
        if(!$model->deliveryman){
            return null;
        }
        return $this->item($model->deliveryman, new DeliverymanTransformer());
    }
}
