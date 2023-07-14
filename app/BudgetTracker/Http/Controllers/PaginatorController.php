<?php
namespace App\BudgetTracker\Http\Controllers;

use Illuminate\Pagination\Paginator;
use App\BudgetTracker\Exceptions\PaginateException;


class PaginatorController {

    /** int $el element of data */
    private int $el;
    private array $data;
    public function __construct(array $data, int $el)
    {
        $this->data = $data;
        $this->el = $el;
    }

    /**
     * 
     */
    public function paginate(int $page = 0): array
	{   
        if($page < 0) {
            throw new PaginateException("Unable retwive page number: ".$page);
        }

		$paginator = $this->paginator($page);
        return [
			'data' => $paginator->items(),
			'hasMorePages' => $paginator->hasMorePages(),
			'currentPage' => $page,
			"paginate" => true
		];

	}

    protected function paginator(int $page): Paginator
    {
        $items = array_slice($this->data, $this->el * $page);
		$paginator = new Paginator($items, $this->el, $page);

		return $paginator;
    }
}