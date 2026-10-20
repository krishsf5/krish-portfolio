<?php

namespace App\Livewire\Public;

use App\Services\BackendService;
use Livewire\Component;

class TechStackSection extends Component
{
    public function render()
    {
        $skills = BackendService::getSkills();

        $row1 = $skills->filter(fn ($s) => in_array($s->category, ['Frontend', 'Backend']))->values();
        $row2 = $skills->filter(fn ($s) => in_array($s->category, ['Database', 'Tools']))->values();

        if ($row1->isEmpty()) {
            $row1 = $skills->values();
        }
        if ($row2->isEmpty()) {
            $row2 = $skills->reverse()->values();
        }

        // Pad to min 8 items for seamless marquee — pure PHP, not in blade
        $row1 = $this->padCollection($row1, 8)->take(16);
        $row2 = $this->padCollection($row2, 8)->take(16);

        return view('livewire.public.tech-stack-section', [
            'skills' => $skills,
            'row1' => $row1,
            'row2' => $row2,
        ]);
    }

    private function padCollection($collection, int $min)
    {
        if ($collection->isEmpty()) {
            return $collection;
        }

        $base = $collection->all(); // keeps Eloquent model objects, not arrays
        $result = $base;

        while (count($result) < $min) {
            $result = array_merge($result, $base);
        }

        return collect($result);
    }
}
