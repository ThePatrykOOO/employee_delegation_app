<?php

namespace Tests\Feature;

use App\Models\Delegation;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class DelegationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreCountryNotFound()
    {
        $employee = Employee::factory()->create();

        $response = $this->post('/api/delegations', [
            'employee_id' => $employee->id,
            'start' => '2021-07-20 08:00:00',
            'end' => '2021-07-21 16:00:00',
            'country' => 'TEST_COUNTRY',
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonFragment([
            'Country not found.'
        ]);
    }

    public function testStartDelegationDateCannotBeLaterThanEndDate()
    {
        $employee = Employee::factory()->create();

        $response = $this->post('/api/delegations', [
            'employee_id' => $employee->id,
            'start' => '2021-07-20 08:00:00',
            'end' => '2021-07-15 16:00:00',
            'country' => 'PL',
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonFragment([
            'The end date delegation must be a date after start date delegation.'
        ]);
    }

    public function testStoreEmployeeHasDelegation()
    {
        $employee = Employee::factory()->create();

        $delegation = Delegation::factory()->create([
            'employee_id' => $employee->id,
            'start' => '2021-07-20 08:00:00',
            'end' => '2021-07-30 16:00:00',
            'country' => 'PL',
        ]);

        $response = $this->post('/api/delegations', [
            'employee_id' => $employee->id,
            'start' => '2021-07-21 08:00:00',
            'end' => '2021-07-22 16:00:00',
            'country' => 'PL',
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonFragment([
            'The employee is currently on delegated.'
        ]);
    }

    public function testStoreDelegationSuccess()
    {
        $employee = Employee::factory()->create();

        $response = $this->post('/api/delegations', [
            'employee_id' => $employee->id,
            'start' => '2021-07-21 08:00:00',
            'end' => '2021-07-22 16:00:00',
            'country' => 'PL',
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(JsonResponse::HTTP_CREATED);

        $this->assertCount(1, Delegation::all());
    }


    public function testGetListOfDelegationsByEmployee()
    {
        /** @var Employee $employee */
        $employee = Employee::factory()->create();

        Delegation::factory()->count(3)->create([
            'employee_id' => $employee->id,
        ]);

        $response = $this->get('/api/delegations/employee/' . $employee->id, [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(JsonResponse::HTTP_OK);

        $data = $response->json();
        $this->assertCount(3, $data);
    }
}
