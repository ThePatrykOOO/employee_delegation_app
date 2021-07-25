<?php


namespace App\Repositories;


use App\Models\Delegation;
use Carbon\Carbon;

class DelegationRepository
{
    /**
     * @param int $employeeId
     * @param Carbon $startTime
     * @param Carbon $endTime
     * @return bool
     */
    public function employeeHasDelegation(int $employeeId, Carbon $startTime, Carbon $endTime): bool
    {
        $delegations = Delegation::query()->where('employee_id', $employeeId)->get();

        /** @var Delegation $delegation */
        foreach ($delegations as $delegation) {
            if (Carbon::parse($startTime)->isBetween($delegation->start, $delegation->end) || Carbon::parse($endTime)->isBetween($delegation->start, $delegation->end)) {
                return true;
            }
        }
        return false;
    }

    public function create(int $employeeId, string $start, string $end, string $country, float $price)
    {
        return Delegation::query()->create([
            'employee_id' => $employeeId,
            'start' => $start,
            'end' => $end,
            'country' => $country,
            'amount_due' => $price,
        ]);
    }

    public function getAllDelegationsByEmployee(int $employeeId)
    {
        return Delegation::query()->where('employee_id', $employeeId)
            ->select('start', 'end', 'country', 'amount_due')
            ->get();
    }
}
