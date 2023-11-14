<?php

namespace App\BudgetTracker\Entity;

use App\User\Services\UserService;
use Illuminate\Support\Facades\Validator;
use App\Rules\Account\AccountColorValidation;
use Illuminate\Support\Traits\EnumeratesValues;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Entity\BudgetTracker;

final class Label implements BudgetTracker
{

    private string $name;
    private string $color;
    private int $archive;
    private int $userId;

    public function __construct(string $name, string $color, int $archive)
    {
        $this->name = $name;
        $this->color = $color;
        $this->archive = $archive;
        $this->userId = UserService::getCacheUserID();

        $this->validate();
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of color
     */
    public function getColor()
    {
        return $this->color;
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


    /**
     * read a resource
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    public function validate(): void
    {
        $rules = [
            'name' => ['required', 'string'],
            'color' => ['required', new AccountColorValidation()],
            'userId' => ['required', 'integer'],
            'archive' => ['required', 'bool'],
        ];

        Validator::validate($this->toArray(), $rules);
    }

    /**
     * Get the value of userId
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Get the value of archive
     *
     * @return int
     */
    public function getArchive(): int
    {
        return $this->archive;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'color' => $this->color,
            'archive' => $this->archive,
            'userId' => $this->userId
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
