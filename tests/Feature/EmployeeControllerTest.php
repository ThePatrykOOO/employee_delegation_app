<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreEmployee()
    {
        $response = $this->post('/api/employee');

        $response->assertStatus(JsonResponse::HTTP_OK);

        $employee = Employee::query()->first();

        $response->assertJsonFragment([
            'id' => $employee->id
        ]);

    }
}
