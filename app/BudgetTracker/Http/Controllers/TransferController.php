<?php

namespace App\BudgetTracker\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Incoming;
use App\BudgetTracker\Models\Transfer;
use App\BudgetTracker\Http\Trait\Paginate;
use App\BudgetTracker\Services\EntryService;
use App\BudgetTracker\Services\WalletService;
use App\BudgetTracker\Services\AccountsService;
use App\BudgetTracker\Services\IncomingService;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Services\TransferService;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Http\Controllers\Controller;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;

class TransferController extends EntryController
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
		$service = new TransferService();
		$incoming = $service->read();

		$response = $incoming->toArray();

		$this->setEl(30);
		$this->setData($response);

		if($page >= 0) {
			$response = $this->paginate($page);
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
			$service = new TransferService();

			$entry = $request->toArray();
			$entry['amount'] = $request['amount'] * -1;
			$service->save($entry);

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
			$service = new TransferService($uuid);
			$service->revertAccountWallet(EntryType::Transfer);
			$entry = $request->toArray();
			$entry['amount'] = $request['amount'] * -1;
			$service->save($entry);

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
		$service = new TransferService();
		$incoming = $service->read($id);
		return response()->json($incoming);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param istringnt $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(string $id): \Illuminate\Http\Response
	{
		$entry = Entry::where('uuid',$id)->firstOrFail();
		$entryTransfer = Entry::where('id',$entry->transfer_id)->firstOrFail();
		try {
			Transfer::destroy($entry->id);
			Transfer::destroy($entryTransfer->id);

			$walletService = new WalletService(EntryService::create($entry->toArray(), EntryType::Transfer));
			$walletService->subtract();
			
			$walletService = new WalletService(EntryService::create($entryTransfer->toArray(), EntryType::Transfer));
			$walletService->subtract();

			return response("Resource is deleted");
		} catch (\Exception $e) {
			return response($e->getMessage());
		}
	}
}
