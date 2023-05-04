<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Services\EntryService;
use App\BudgetTracker\Services\ResponseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use App\BudgetTracker\Enums\EntryType;

class SearchEntriesController extends Controller
{
	//
	/**
	 * Display a listing of the resource.
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function find(Request $request): \Illuminate\Http\JsonResponse
	{	

		try {
			$entry = Entry::withRelations();

			if (!empty($request->account)) {
				$entry->whereIn('account_id', $request->account);
			}
			if (!empty($request->category)) {
				$entry->whereIn('category_id', $request->category);
			}
	
			if (!empty($request->planned)) {
				$entry->where('planned', $request->planned);
			}
	
			if (!empty($request->text)) {
				$entry->where('note', 'like', "%$request->text%");
			}
	
			if (!empty($request->type)) {
				$entry->whereIn('type', $request->type);
			}
	
			if (!empty($request->month) || !empty($request->year)) {
				$date = $this->buildFilterData($request->year,$request->month);
				$entry->where('date_time', '>=', $date['start']);
				$entry->where('date_time', '<=', $date['end']);
			}
			
			//FIXME: doesn't works
			if (!empty($request->tags)) {
				$tags = $request->tags;
				$entry->whereHas('label', function (Builder $q) use ($tags) {
					$q->whereIn('labels.id', $tags);
				});
			}

			$data = $entry->get();
			$returnValue = $data;

			$total = [];

			$entriesData = EntryService::splitEntry_byType($data);

			foreach($entriesData as $key => $entry) {
				$entryService = new EntryService();
				$entryService->setData($entriesData[$key]);
				$total[strtolower($key)] = $entryService->sum();
			}

			return response()->json(new ResponseService(['elements' => $returnValue, 'total' => $total]));

		} catch (\Exception $e) {
			$id = uniqid();
			Log::error($id . ' An error occurend wile find # '.$e->getMessage());
			return response()->json(new ResponseService([],'Ops an error occurred ',$id));
		}
		
	}

	/**
	 * build valid data
	 * @param string|null $year
	 * @param string|null $month
	 * 
	 * @return array
	 */
	protected function buildFilterData(string|null $year = '', string|null $month = ''): array
	{
		if(empty($year)) {
			$year = date("Y",time());
		}

		if(empty($month)) {
			$month = date("m",time());
		}

		$dateTime = new \DateTime();
		$dateTime->setDate((int)$year,(int)$month,1);

		return [
			'start' => $this->getStartDate((int)$year,(int)$month),
			'end' => $this->getEndDate((int)$year,(int)$month)
		];

	}

	/**
	 * make date time
	 * @param int $year
	 * @param int $month
	 * 
	 * @return string
	 */
	private function getStartDate(int $year, int $month): string
	{
		$dateTime = new \DateTime();
		$dateTime->setDate((int)$year,(int)$month,1);
		$dateTime->modify('first day of this month');
		return $dateTime->format('Y-m-d H:i:s');
	}

		/**
	 * make date time
	 * @param int $year
	 * @param int $month
	 * 
	 * @return string
	 */
	private function getEndDate(int $year, int $month): string
	{
		$dateTime = new \DateTime();
		$dateTime->setDate((int)$year,(int)$month,1);
		$dateTime->modify('last day of this month');
		return $dateTime->format('Y-m-d H:i:s');

	}
}
