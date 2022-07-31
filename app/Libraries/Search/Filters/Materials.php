<?php

namespace App\Libraries\Search\Filters;

class Materials extends BaseFilteredList
{
    protected $parameter = 'material_ids';
    protected $entity = \App\Models\Api\CategoryTerm::class;

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => 'Find Medium',
                'title' => 'Medium',
                'active' => $this->activeList,
                'list' => $list,
                'listSearch' => true,
                'type' => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->except(['categoryQuery']) + ['categoryName' => 'materials'])
            ];
        }
    }

    public function findLabel($key)
    {
        return ucfirst($key);
    }
}
