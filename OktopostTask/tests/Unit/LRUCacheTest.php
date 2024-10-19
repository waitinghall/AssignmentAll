<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\LRUCache;

class LRUCacheTest extends TestCase
{
    // Test for adding and retrieving data
    public function testPutAndGet()
    {
        $cache = new LRUCache(3);

        $cache->put('a', '1');
        $cache->put('b', '2');
        $cache->put('c', '3');

        $this->assertEquals('1', $cache->get('a'));
        $this->assertEquals('2', $cache->get('b'));
        $this->assertEquals('3', $cache->get('c'));
    }

    // Test for eviction of the least recently used item
    public function testEvictionOfLeastRecentlyUsed()
    {
        $cache = new LRUCache(3);

        $cache->put('a', '1');
        $cache->put('b', '2');
        $cache->put('c', '3');

        // Use 'a' and 'b' so they become "recently used"
        $cache->get('a');
        $cache->get('b');

        // Add new item, 'c' should be evicted
        $cache->put('d', '4');

        $this->assertNull($cache->get('c')); // 'c' should be evicted
        $this->assertEquals('1', $cache->get('a')); // 'a' should remain
        $this->assertEquals('2', $cache->get('b')); // 'b' should remain
        $this->assertEquals('4', $cache->get('d')); // 'd' added
    }

    // Test for updating an existing value
    public function testUpdateExistingValue()
    {
        $cache = new LRUCache(3);

        $cache->put('a', '1');
        $cache->put('b', '2');
        $cache->put('c', '3');

        $cache->put('b', '22'); // Update the value of 'b'

        $this->assertEquals('22', $cache->get('b')); // Check update

        $cache->put('d', '4'); // Add new item

        $this->assertNull($cache->get('a')); // 'a' should be evicted
        $this->assertEquals('22', $cache->get('b')); // 'b' should remain updated
        $this->assertEquals('3', $cache->get('c')); // 'c' should remain
        $this->assertEquals('4', $cache->get('d')); // 'd' added
    }

    // Test to ensure proper LRU mechanism
    public function testLRUMechanism()
    {
        $cache = new LRUCache(2);

        // Add two items
        $cache->put('x', '10');
        $cache->put('y', '20');

        // Use 'x', it should become "recently used"
        $cache->get('x');

        // Add new item, 'y' should be evicted as the oldest
        $cache->put('z', '30');

        $this->assertNull($cache->get('y')); // 'y' should be evicted
        $this->assertEquals('10', $cache->get('x')); // 'x' should remain
        $this->assertEquals('30', $cache->get('z')); // 'z' added
    }

    // Long test sequence with console output and checks
    public function testLongSequenceOfOperations()
    {
        // Create cache with capacity for 3 items
        $cache = new LRUCache(3);
        echo "Initial cache state: ";
        print_r($cache->getCacheState());

        // Add three items
        $cache->put('a', '1');
        echo "\nAfter adding ('a', '1'): ";
        print_r($cache->getCacheState());

        $cache->put('b', '2');
        echo "\nAfter adding ('b', '2'): ";
        print_r($cache->getCacheState());

        $cache->put('c', '3');
        echo "\nAfter adding ('c', '3'): ";
        print_r($cache->getCacheState());

        // Retrieve 'a' (it should become the most recent)
        $cache->get('a');
        echo "\nAfter getting 'a': ";
        print_r($cache->getCacheState());

        // Add new item 'd', 'b' should be evicted
        $cache->put('d', '4');
        echo "\nAfter adding ('d', '4') and evicting 'b': ";
        print_r($cache->getCacheState());

        // Add another item 'e', 'c' should be evicted
        $cache->put('e', '5');
        echo "\nAfter adding ('e', '5') and evicting 'c': ";
        print_r($cache->getCacheState());

        // Update item 'a', it should become the most recent
        $cache->put('a', '10');
        echo "\nAfter updating ('a', '10'): ";
        print_r($cache->getCacheState());

        // Perform more get operations
        $cache->get('d');
        echo "\nAfter getting 'd': ";
        print_r($cache->getCacheState());

        $cache->get('e');
        echo "\nAfter getting 'e': ";
        print_r($cache->getCacheState());

        // Add new item 'f', 'a' should be evicted
        $cache->put('f', '6');
        echo "\nAfter adding ('f', '6') and evicting 'a': ";
        print_r($cache->getCacheState());

        // Expected final cache state: 'd', 'e', 'f'
        echo "\nFinal cache state: ";
        print_r($cache->getCacheState());

        // Expected values
        $this->assertNull($cache->get('a')); // 'a' was evicted
        $this->assertEquals('4', $cache->get('d')); // 'd' remains
        $this->assertEquals('5', $cache->get('e')); // 'e' remains
        $this->assertEquals('6', $cache->get('f')); // 'f' was added
    }
}
