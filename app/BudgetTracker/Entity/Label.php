<?php

namespace App\BudgetTracker\Entity\Accounts;

use League\Config\Exception\ValidationException;
use App\Rules\Account\AccountColorValidation;
use Carbon\Traits\Serialization;

final class Label {

    use Serialization;

    private string $name;
    private string $color;

    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;

        $this->validate();

    }

    public function hash(): string
    {
        return md5("{$this->name}{$this->color}");
    }

    public function isEqualsTo(Label $account): bool
    {
        return $this->hash() === $account->hash();
    }

    /**
     * read a resource
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    private function validate(): void
    {
        $rules = [
            'name' => ['required', 'string'],
            'color' => ['required',new AccountColorValidation()],
        ];

    }
}