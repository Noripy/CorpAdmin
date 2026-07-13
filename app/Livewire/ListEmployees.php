<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Component;

/**
 * 従業員一覧ページで使用するコンポーネント
 */
class ListEmployees extends Component
{
    // フィルタ検索
    public ?string $department = null; 
    public ?string $position = null;

    public function render()
    {
        $departments = Employee::query()
            ->whereNotNull('department')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        $positions = Employee::query()
            ->whereNotNull('position')
            ->distinct()
            ->orderBy('position')
            ->pluck('position');

        $employees = Employee::query()
            ->when($this->department, fn ($q) => $q->where('department', $this->department))
            ->when($this->position, fn ($q) => $q->where('position', $this->position))
            ->get();

        // どの画面に何のオブジェクトを渡すか
        return view('livewire.list-employees', [
            'employees'   => $employees,
            'departments' => $departments,
            'positions'   => $positions,
        ]);
    }

    public function resetFilters()
    {
        $this->department = null;
        $this->position = null; 
    }


}
