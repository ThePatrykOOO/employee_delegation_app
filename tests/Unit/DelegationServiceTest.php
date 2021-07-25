<?php

namespace Tests\Unit;

use App\Services\DelegationService;
use Carbon\Carbon;
use Tests\TestCase;

class DelegationServiceTest extends TestCase
{

    public function testDelegationHasLessThanDailyWorkingHours()
    {
        /** @var DelegationService $delegationService */
        $delegationService = app(DelegationService::class);

        $startTime = Carbon::parse('2021-07-20 08:00:00');
        $endTime = Carbon::parse('2021-07-20 10:00:00');

        $this->assertEquals(0.0, $delegationService->calculateAmountDue('PL', $startTime, $endTime));
    }
    public function testCalculateDietForPolandEmployeeWhenIsOn1DayOnDelegation()
    {
        /** @var DelegationService $delegationService */
        $delegationService = app(DelegationService::class);

        $startTime = Carbon::parse('2021-07-20 08:00:00');
        $endTime = Carbon::parse('2021-07-20 18:00:00');

        $this->assertEquals(10.0, $delegationService->calculateAmountDue('PL', $startTime, $endTime));
    }

    public function testCalculateDietForPolandEmployeeWhenIsOn3DaysOnDelegation()
    {
        /** @var DelegationService $delegationService */
        $delegationService = app(DelegationService::class);

        $startTime = Carbon::parse('2021-07-20 08:00:00');
        $endTime = Carbon::parse('2021-07-22 10:00:00');

        $this->assertEquals(30.0, $delegationService->calculateAmountDue('PL', $startTime, $endTime));
    }

    public function testCalculateDietForPolandEmployeeWhenDelegationIncludeWeekend()
    {
        /** @var DelegationService $delegationService */
        $delegationService = app(DelegationService::class);

        $startTime = Carbon::parse('2021-07-14 08:00:00');
        $endTime = Carbon::parse('2021-07-19 10:00:00');

        $this->assertEquals(40.0, $delegationService->calculateAmountDue('PL', $startTime, $endTime));
    }

    public function testCalculateDietForPolandDoubleDailyAllowance()
    {
        /** @var DelegationService $delegationService */
        $delegationService = app(DelegationService::class);

        $startTime = Carbon::parse('2021-07-10 08:00:00');
        $endTime = Carbon::parse('2021-07-19 10:00:00');

        $this->assertEquals(120.0, $delegationService->calculateAmountDue('PL', $startTime, $endTime));
    }

    public function testCalculateDietForPolandEmployeeWhenDelegationHasDayWithLessThanDailyWorkingHours()
    {
        /** @var DelegationService $delegationService */
        $delegationService = app(DelegationService::class);

        $startTime = Carbon::parse('2021-07-14 22:00:00');
        $endTime = Carbon::parse('2021-07-16 02:00:00');

        $this->assertEquals(10.0, $delegationService->calculateAmountDue('PL', $startTime, $endTime));
    }
}
