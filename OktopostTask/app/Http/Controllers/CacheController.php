<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LRUCache;
use Illuminate\Support\Facades\Redis;

class CacheController extends Controller
{
    protected LRUCache $cache;

    public function showForm()
    {
        // Ensure the cache is up-to-date
        $this->refreshCache();

        // Retrieve the current cache state
        $cacheState = $this->cache->getCacheState();
        return view('cache.form', ['cacheState' => $cacheState]);
    }

    public function put(Request $request)
    {
        // Ensure the cache is up-to-date before modifying it
        $this->refreshCache();

        $key = $request->input('key');
        $value = $request->input('value');

        // Add the item to the cache
        $this->cache->put($key, $value);

        // Serialize the object and save it to Redis
        Redis::set('lru_cache', serialize($this->cache));

        return redirect('/cache')->with('success', "Key '{$key}' with value '{$value}' added.");
    }

    public function get(Request $request)
    {
        // Ensure the cache is up-to-date before accessing it
        $this->refreshCache();

        $key = $request->input('key');
        $value = $this->cache->get($key);

        if ($value === null) {
            return redirect()->back()->with('error', "Key '{$key}' not found.");
        }

        return redirect('/cache')->with('success', "Value for key '{$key}': {$value}");
    }

    public function refreshCache()
    {
        // Retrieve the cache from Redis
        $cachedData = Redis::get('lru_cache');

        if ($cachedData) {
            // Restore the object from the serialized string
            $this->cache = unserialize($cachedData);
        } else {
            // Create a new cache if no data is found
            $this->cache = new LRUCache(3);
        }
    }
}
