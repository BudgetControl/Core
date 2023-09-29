<?php
namespace App\BudgetTracker\Http\Trait;

use Illuminate\Pagination\Paginator;
use App\BudgetTracker\Exceptions\PaginateException;


trait Paginate {

    /** int $el element of data */
    private int $el;
    private array $itemsData;

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
        $items = array_slice($this->itemsData, $this->el * $page);
		$paginator = new Paginator($items, $this->el, $page);

		return $paginator;
    }

    /**
     * Get the value of el
     *
     * @return int
     */
    public function getEl(): int
    {
        return $this->el;
    }

    /**
     * Set the value of el
     *
     * @param int $el
     *
     * @return self
     */
    public function setEl(int $el): self
    {
        $this->el = $el;

        return $this;
    }

    /**
     * Get the value of data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->itemsData;
    }

    /**
     * Set the value of data
     *
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data): self
    {
        $this->itemsData = $data;

        return $this;
    }
}