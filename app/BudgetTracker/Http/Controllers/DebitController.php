<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use App\BudgetTracker\Http\Trait\Paginate;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Models\Debit;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\Incoming;
use App\BudgetTracker\Services\AccountsService;
use App\BudgetTracker\Services\DebitService;
use App\BudgetTracker\Services\IncomingService;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Services\ResponseService;

class DebitController extends EntryController
{
	use Paginate;
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(Request $filter): \Illuminate\Http\JsonResponse
	{
		$page = $filter->query('page');
		$service = new DebitService();
		$incoming = $service->read();
		$response = $incoming->toArray();

		if(!is_null($page)) {
			$this->setEl(30);
			$this->setData($response);
			if($page >= 0) {
				$response = $this->paginate($page);
			}
		}



		return response()->json($response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request): \Illuminate\Http\Response
	{
		try {
			$debitService = new DebitService();
			$debitService->save($request->toArray());
			return response('All data stored');
		} catch (\Exception $e) {
			return response($e->getMessage(), 500);
		}
	}

		/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, string $uuid): \Illuminate\Http\Response
	{
		try {
			$service = new DebitService($uuid);
			$service->save($request->toArray());
			return response('All data stored');
		} catch (\Exception $e) {
			return response($e->getMessage(), 500);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param string $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(string $id): \Illuminate\Http\JsonResponse
	{
		$service = new DebitService();
		$incoming = $service->read($id);
		return response()->json($incoming);
	}

}
