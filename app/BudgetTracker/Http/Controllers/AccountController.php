<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Models\Account;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Services\AccountsService;

class AccountController extends Controller implements ControllerResourcesInterface
{
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(): \Illuminate\Http\JsonResponse
	{
		$account = new AccountsService();
		$account = $account->all();
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
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(int $id): \Illuminate\Http\Response
	{
		return response('nothing');
	}
}
