<?php

namespace App\BudgetTracker\Entity;

use Illuminate\Support\Facades\Cache as Caching;

/**
 * @ Author: Your name
 * @ Create Time: 2024-01-27 19:11:57
 * @ Modified by: Your name
 * @ Modified time: 2024-01-27 19:12:15
 * @ Description:
 */

final class Cache
{
    private string $key;
    private array $tags;

    const TTL_FOREVER = 1;
    const TTL_ONEDAY = 86400;
    const TTL_ONEWEEK = 604800;
    const TTL_ONEMONTH = 2919200;

    private function __construct(string $key, array $tags)
    {
        $this->tags = $tags;
        $this->key = sha1($key);
    }
    
    /**
     * create
     *
     * @param  string $key
     * @return Cache
     */
    public static function create(string $key, array $tags = []): Cache
    {
        if(empty($tags)) {
            $tags = [session()->getId()];
        }
        return new Cache($key, $tags);
    }
    
        
    /**
     * get
     *
     * @param  mixed $value
     * @return mixed
     */
    public function  get(): mixed
    {
        $data = Caching::get($this->key);

        return $data;
    }
    
    /**
     * set
     *
     * @param  mixed $value
     * @param  int $ttl
     * @return void
     */
    public function set(mixed $value, int $ttl = 3600): void
    {
        if($ttl === 1) {
            Caching::tags($this->tags)->forever($this->key,$value);
        } else {
            Caching::tags($this->tags)->put($this->key,$value,$ttl);
        }
    }
    
    public function delete()
    {
        Caching::delete($this->key);
    }

    public function clear()
    {
        Caching::tags($this->tags)->delete($this->key);
    }

}
