<?php

namespace App\Rules;

use App\Repositories\DelegationRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class EmployeeInDelegationRule implements Rule
{
    /**
     * @var string
     */
    private $startTime;
    /**
     * @var string
     */
    private $endTime;

    public function __construct( string $startTime, string $endTime)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $employeeId
     * @return bool
     */
    public function passes($attribute, $employeeId)
    {
        /** @var DelegationRepository $employeeRepository */
        $employeeRepository = app(DelegationRepository::class);
       return $employeeRepository->employeeHasDelegation($employeeId, Carbon::parse($this->startTime), Carbon::parse($this->endTime)) === false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The employee is currently on delegated.';
    }
}
