<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function store()
    {
        $employee = new Employee();
        $employee->save();

        return response()->json([
            'id' => $employee->id
        ]);
    }
}
