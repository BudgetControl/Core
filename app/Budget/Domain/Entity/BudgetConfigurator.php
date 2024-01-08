<?php

namespace App\Budget\Domain\Entity;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Enums\PlanningType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Category;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Models\SubCategory;

class BudgetConfigurator
{

    private array $account;
    private readonly float $balance;
    private array $type;
    private PlanningType $planningType;
    private array $category;
    private array $label;
    private string $name;

    public function __construct(float $balance, PlanningType $planningType)
    {
        $this->account = [];
        $this->category = [];
        $this->label = [];
        $this->type = [];
        $this->name = '';
        $this->balance = $balance;
        $this->planningType = $planningType;
    }

    public function toJson(): string
    {
        $data = [];
        $data['balance'] = $this->balance;
        $data['planning_type'] = $this->planningType->value;

        $data['account'] = $this->account;

        $data['category'] = $this->category;

        $data['label'] = $this->label;

        /** @var EntryType $type */
        foreach ($this->type as $type) {
            $data['type'][] = $type->value;
        }

        return json_encode($data);
    }

    /**
     * Get the value of account
     *
     * @return array
     */
    public function getAccount(): array
    {
        return $this->account;
    }

    /**
     * Set the value of account
     *
     * @param Account $account
     *
     * @return self
     */
    public function setAccount(Account $account): self
    {
        $this->account[] = $account->id;

        return $this;
    }

    /**
     * Get the value of balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Get the value of type
     *
     * @return array
     */
    public function getType(): array
    {
        return $this->type;
    }

    /**
     * Get the value of planningType
     *
     * @return PlanningType
     */
    public function getPlanningType(): PlanningType
    {
        return $this->planningType;
    }


    /**
     * Set the value of type
     *
     * @param EntryType $type
     *
     * @return self
     */
    public function setType(EntryType $type): self
    {
        $this->type[] = $type;

        return $this;
    }


    /**
     * Set the value of category
     *
     * @param SubCategory $category
     *
     * @return self
     */
    public function setCategory(SubCategory $category): self
    {
        $this->category[] = $category->id;

        return $this;
    }


    /**
     * Set the value of label
     *
     * @param Labels $label
     *
     * @return self
     */
    public function setLabel(Labels $label): self
    {
        $this->label[] = $label->id;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
