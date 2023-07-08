<?php
namespace Search\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Search\Services;
use Search\Services\SearchService;
use Illuminate\Pagination\Paginator;
use Search\Entity\Search;

class SearchController {
    
    const PAGINATION = 30;

	//
	/**
	 * Display a listing of the resource.
	 * @return JsonResponse
	 * @throws \Exception
	 */
	public function index(Request $filter): JsonResponse
	{
        $page = $filter->query('page');

        $month = date('m',time());
        $year = date('Y',time());

		$service = new SearchService($month,$year);
        $entry = $service->find([]);
        $paginator = $this->paginate($entry->getEntry(),$page);

		return response()->json([
                'data' => $paginator->items(),
                'balance' => $entry->getBalance(),
                'hasMorePages' => $paginator->hasMorePages(),
                'currentPage' => $page,
        ]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Request $filter
	 * @return JsonResponse
	 */
	public function show(Request $filter): JsonResponse
	{	
        $page = $filter->query('page');

		$month = $filter->month;
		if(empty($month)) {
			$month = date('m',time());
		}

		$year = $filter->year;
		if(empty($year)) {
			$year = date('Y',time());
		}

		$service = new SearchService($month,$year);
        $entry = $service->find($filter->toArray());
        $paginator = $this->paginate($entry->getEntry(),$page);
		$items = $paginator->items();
		$paginate = count($items) >= self::PAGINATION;

		return response()->json([
                'data' => $items,
                'balance' => $entry->getBalance(),
                'hasMorePages' => $paginator->hasMorePages(),
                'currentPage' => $page,
                'paginate' => $paginate,
        ]);

	}

    private function paginate(array $items, int $page): Paginator
    {   
		if(count($items) >= self::PAGINATION) {
			$items = array_slice($items, self::PAGINATION * $page);
		}
        $paginator = new Paginator($items,self::PAGINATION,$page);

        return $paginator;
    }

}
