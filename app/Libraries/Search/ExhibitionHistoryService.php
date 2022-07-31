<?php

namespace App\Libraries\Search;

/**
 * Port from old exhibitions history controller. Should be refactored and optimized.
 *
 */

class ExhibitionHistoryService
{
    protected $decadePrompt = '';
    protected $decades = [];

    public function activeYear()
    {
        $default = date('Y') - (date('n') < 3 ? 1 : 0);

        return intval(request()->get('year') ?? $default);
    }

    public function decades()
    {
        if (!empty($this->decades)) {
            return $this->decades;
        }

        foreach (range(1880, date('Y'), 10) as $decade) {
            if ($decade < 1890) {
                $decade = 1883;
                $decadeEnd = 1889;
            } else {
                $decadeEnd = ($decade + 9) > date('Y') ? date('Y') : $decade + 9;
            }

            $d = [
                'href' => route('exhibitions.history', ['year' => $decade]),
                'label' => join('–', [$decade, $decadeEnd]),
                'start' => $decade,
                'end' => $decadeEnd,
                'ajaxScrollTarget' => 'listing'
            ];

            if ($this->activeYear() >= $decade && $this->activeYear() <= $decadeEnd) {
                $d['active'] = true;
                $this->decadePrompt = $d['label'];
            }

            $this->decades[] = $d;
        }

        return collect($this->decades)->reverse();
    }

    public function years()
    {
        $active = collect($this->decades())->where('active', true)->first();

        foreach (range($active['start'], $active['end']) as $year) {
            if ($year <= date('Y')) {
                $years[] = [
                    'href' => route('exhibitions.history', ['year' => $year]),
                    'label' => $year,
                    'active' => $this->activeYear() == $year,
                    'ajaxScrollTarget' => 'listing'
                ];
            }
        }

        return collect($years)->reverse();
    }

    public function getDecadePrompt()
    {
        return $this->decadePrompt;
    }
}
