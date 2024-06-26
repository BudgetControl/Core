<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Entity\DateTime;
use Illuminate\Http\Request;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Enums\EntryType;
use Illuminate\Database\Eloquent\Builder;
use App\BudgetTracker\Http\Trait\Paginate;
use App\BudgetTracker\Services\EntryService;
use App\BudgetTracker\Services\WalletService;
use App\BudgetTracker\Services\AccountsService;
use App\BudgetTracker\Http\Controllers\Controller;
use Carbon\Carbon;

class EntryController extends Controller
{
	use Paginate;

	const PAGINATION = 30;

	const FILTER = ['account', 'category', 'type', 'label'];

	protected Builder $builder;

	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(Request $filter): \Illuminate\Http\JsonResponse
	{
		$page = $filter->query('page');
		
		$this->builder = Entry::User()->withRelations()->where("date_time", "<=", Carbon::now()->lastOfMonth()->toAtomString())->orderBy("date_time", "desc");
		if(!empty($filter->query('filter'))) {
			$this->filter($filter->query('filter'));
		}

		$this->setEl(30, $page);
		return response()->json($this->paginate($page));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request): \Illuminate\Http\Response
	{
		$type = EntryType::from($request->type);
		try {
			$service = new EntryService();
			$service->save($request->toArray(), $type, Payee::find($request->payee_id));
			return response('All data stored');
		} catch (\Exception $e) {
			return response($e->getMessage(), 500);
		}
	}

	/**
	 * get from specific account
	 * @param int $id
	 * 
	 * @return \Illuminate\Http\JsonResponse
	 */
	static public function getEntriesFromAccount(int $id): \Illuminate\Http\JsonResponse
	{
		$incoming = Entry::User()->withRelations()->where("account_id", $id)->get();
		return response()->json($incoming);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(string $id): \Illuminate\Http\JsonResponse
	{
		$service = new EntryService();
		$incoming = $service->read($id);
		return response()->json($incoming);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(string $id): \Illuminate\Http\Response
	{
		try {
			$entry = Entry::where('uuid', $id)->firstOrFail();

			$walletService = new WalletService(
				EntryService::create($entry->toArray(), EntryType::from($entry->type))
			);
			$walletService->subtract();

			Entry::destroy($entry->id);

			return response("Resource is deleted");
		} catch (\Exception $e) {
			return response($e->getMessage());
		}
	}

	/**
	 * check valid filter
	 * @param array $filter
	 * 
	 * @return void
	 * @throws Exception
	 */
	private function filter(array $filter): void
	{
		foreach ($filter as $key => $value) {
			if (!in_array($key, self::FILTER)) {
				throw new \Exception("Filter must be one of these account, type, category, label - " . $key . " is not valid!");
			}
		}

		if (!empty($filter['account'])) {
			$this->builder->where('account_id', $filter['account']);
		}

		if (!empty($filter['category'])) {
			$this->builder->where('category_id', $filter['category']);
		}

		if (!empty($filter['type'])) {
			$this->builder->where('type', $filter['type']);
		}

		if (!empty($filter['label'])) {
			$tags = (array) $filter['label'];
			$this->builder->whereHas('label', function (Builder $q) use ($tags) {
				$q->whereIn('labels.id', $tags);
			});
		}
	}

	/**
	 * retrive all data
	 */
	protected function getEntry(?EntryType $type = null): Builder
	{
		$builder = Entry::User()->withRelations()
			->where("planned", 0)
			->orderBy("date_time", "desc");

		if (!is_null($type)) {
			$builder->where("type", $type->value);
		}

		return $builder;
	}
}
