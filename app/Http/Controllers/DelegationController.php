<?php

namespace App\Http\Controllers;

use App\Http\Requests\DelegationRequest;
use App\Repositories\DelegationRepository;
use App\Services\DelegationService;
use Carbon\Carbon;

class DelegationController extends Controller
{
    /**
     * @var DelegationService
     */
    private $delegationService;
    /**
     * @var DelegationRepository
     */
    private $delegationRepository;

    public function __construct(DelegationService $delegationService, DelegationRepository $delegationRepository)
    {
        $this->delegationService = $delegationService;
        $this->delegationRepository = $delegationRepository;
    }

    public function listDelegationsByEmployee(int $employeeId): \Illuminate\Http\JsonResponse
    {
        $delegations = $this->delegationRepository->getAllDelegationsByEmployee($employeeId);
        return response()->json($delegations);
    }

    public function store(DelegationRequest $request)
    {
        $data = $request->validated();
        $amountDue = $this->delegationService->calculateAmountDue($data['country'], Carbon::parse($data['start']), Carbon::parse($data['end']));

        return $this->delegationRepository->create($data['employee_id'], $data['start'], $data['end'], $data['country'], $amountDue);


    }
}
