<?php

namespace App\Livewire;

use App\Models\Employee;
use Livewire\Component;

/**
 * 従業員一覧ページで使用するコンポーネント
 */
class ListEmployees extends Component
{
    public $employees;

    public function mount()
    {
        $this->employees = Employee::all();
    }
    
    public function render()
    {
        // Viewメソッド第一引数の名称に合わせる
        return view('livewire.list-employees', [
            'employees' => Employee::all(),
        ]);
    }


}
