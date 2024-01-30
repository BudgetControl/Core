<?php

namespace App\Auth\Entity;

use App\BudgetTracker\Entity\Cache;

/**
 * @ Author: Your name
 * @ Create Time: 2024-01-27 19:11:57
 * @ Modified by: Your name
 * @ Modified time: 2024-01-27 19:12:15
 * @ Description:
 */

class Token
{
    private string $token;
    protected mixed $data;

    private function __construct(mixed $data)
    {
        $this->data = $data;
        $this->token = $this->generate($data);
    }
    
    /**
     * create
     *
     * @param  string $key
     * @return Token
     */
    public static function create(mixed $data): Token
    {
        return new Token($data);
    }
    
    /**
     * generate
     *
     * @return string
     */
    private function generate(mixed $data): string
    {
        if(is_iterable($data)) {
            $data = json_encode($data);
        }

        return sha1($data);
    }

    /**
     * Get the value of token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * save token in cache
     */
    public function saveCache(): self
    {
        Cache::create($this->token)->set($this->data);
        return $this;
    }

}
