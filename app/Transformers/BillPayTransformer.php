<?php

namespace SON\Transformers;

use League\Fractal\TransformerAbstract;
use SON\Models\BillPay;

/**
 * Class BillPayTransformer
 * @package namespace SON\Transformers;
 */
class BillPayTransformer extends TransformerAbstract
{

    /**
     * Transform the \BillPay entity
     * @param \BillPay $model
     *
     * @return array
     */
    public function transform(BillPay $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
