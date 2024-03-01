<?php

namespace App\BudgetTracker\Traits;

use App\BudgetTracker\Entity\Cache;

/**
 * 
 */

trait Caching
{
    protected int $ttl = 3600;
    abstract public function getHash();

    /**
     * save in cache
     */
    public function saveInCache(): self
    {
        Cache::create($this->workspace->getUuid())->set($this, $this->ttl);

        return $this;
    }

    /**
     * save in cache
     */
    public function saveInCacheFromSession(): self
    {
        Cache::create(session()->getId())->set($this);

        return $this;
    }

    /**
     * save in cache
     */
    public function getFromCache(): self
    {
        $this->workspace = Cache::create($this->getHash())->get();
        return $this->workspace;
    }

    /**
     * save in cache
     */
    public static function getCacheFromSession(): self
    {
        return Cache::create(session()->getId())->get();
    }

    /**
     * delete cache objet
     */
    public function destroy(): void
    {
        Cache::create($this->getHash())->delete();
    }

}
