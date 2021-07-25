<?php


namespace App\Services;


use Carbon\Carbon;

class DelegationService
{

    const DAILY_WORKING_HOURS = 8;
    const DOUBLE_DAILY_ALLOWANCE_AFTER_DETERMINED_DAYS = 7;

    public function calculateAmountDue(string $country, Carbon $startTime, Carbon $endTime): float
    {
        if ($startTime->diffInHours($endTime) < self::DAILY_WORKING_HOURS) {
            return 0.0;
        }

        $dailyAllowance = config('country_price_diet')[$country];

        if ($startTime->diffInDays($endTime) == 0) {
            return $dailyAllowance;
        } elseif ($startTime->diffInDays($endTime) >= self::DOUBLE_DAILY_ALLOWANCE_AFTER_DETERMINED_DAYS) {
            $dailyAllowance *= 2;
        }


        $sumAmount = 0;

        while ($startTime->lessThanOrEqualTo($endTime)) {
            $startTimeCopy = clone $startTime;
            $endTimeCopy = clone $endTime;

            if ($startTime->isWeekend() === false &&
                ($startTime->diffInHours($startTimeCopy->endOfDay()) > self::DAILY_WORKING_HOURS || $startTime->diffInHours($endTimeCopy->startOfDay()) > self::DAILY_WORKING_HOURS) &&
                ($startTime->diffInHours($endTime) > self::DAILY_WORKING_HOURS && $startTime->diffInHours($startTimeCopy->endOfDay()) > self::DAILY_WORKING_HOURS)
            ) {
                $sumAmount += $dailyAllowance;
            }

            $startTime->endOfDay()->addSecond();
        }


        return $sumAmount;
    }
}
