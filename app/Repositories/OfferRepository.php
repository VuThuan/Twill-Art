<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Models\Offer;

class OfferRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(Offer $model)
    {
        $this->model = $model;
    }
}
