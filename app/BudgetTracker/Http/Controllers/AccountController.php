<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Services\AccountsService;
use Exception;
use Illuminate\Http\Response;

class AccountController extends Controller
{
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(Request $request): \Illuminate\Http\JsonResponse
	{
		$account = Account::User();
		if($request->query("trashed",0) == 1) {
			$account->withTrashed();
		}

		$account = $account->get();

		
		return response()->json(new ResponseService($account->toArray()));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request): \Illuminate\Http\Response
	{
		$account = new AccountsService();
		$account->save($request->toArray());

		return response('all data stored');
	}

	/**
	 * store new sorting value
	 * @param int $accountId
	 * @param int $sorting
	 * 
	 * @return Response
	 */
	public function sorting(int $accountId, int $sorting): Response
	{
		if(is_null($sorting)) {
			throw new Exception("Sorting value muste be valid");
		}

		$account = new AccountsService($accountId);
		$account->sorting($sorting);

		return response('all data stored'); 	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $id): \Illuminate\Http\JsonResponse
	{
		$account = new AccountsService();
		$account = $account->read($id);

		return response()->json($account->toArray());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @param string $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, int $id): \Illuminate\Http\Response
	{
		$account = new AccountsService($id);
		$account->save($request->toArray());

		return response('all data stored');
	}

	/**
	 * restore deleted account
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function restore(int $id): \Illuminate\Http\Response
	{
		Account::withTrashed()->find($id)->restore();
		$entries = Entry::withTrashed()->where("account_id", $id)->get();
		foreach($entries as $entry) {
			$entry->restore();
		}

		return response('all data restored');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(int $id): \Illuminate\Http\Response
	{
		$toDestroy = [];
		Account::destroy($id);
		$entries = Entry::where("account_id", $id)->get();
		foreach($entries as $entry) {
			$toDestroy[] = $entry->id;
		}
		Entry::destroy($toDestroy);

		return response('all data deleted');
	}
}
