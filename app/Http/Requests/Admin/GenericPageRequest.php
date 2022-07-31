<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class GenericPageRequest extends Request
{
    public function rules()
    {
        return [
            'listing_description' => 'max:255',
        ];
    }
}
