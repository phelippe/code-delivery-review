<?php

namespace CodeDelivery\Http\Requests;

use Illuminate\Http\Request as HttpRequest;

class CheckoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //#por sempre true nisso aqui
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(HttpRequest $request)
    {
        $rules = [
            'cupom_code' => 'exists:cupoms,code,used,0',
        ];
        $this->buildResultItems(0, $rules);
        $items = $request->get('items', []);
        $items = !is_array($items) ? [] : $items;
        foreach ($items as $key => $val){
            $this->buildResultItems($key, $rules);
        }
        return $rules;
    }

    public function buildResultItems($key, array &$rules)
    {
        $rules["items.$key.product_id"] = 'required';
        $rules["items.$key.qtd"] = 'required';
    }
}
