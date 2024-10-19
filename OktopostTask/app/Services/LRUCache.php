<?php
namespace App\Services;

use Serializable;

class LRUCache implements Serializable
{
    private $capacity;
    private $cache = [];
    private $head;
    private $tail;

    public function __construct($capacity)
    {
        $this->capacity = $capacity;
        $this->head = new ListNode(null, null); // Create a dummy head node
        $this->tail = new ListNode(null, null); // Create a dummy tail node
        $this->head->next = $this->tail; // Head points to tail initially
        $this->tail->prev = $this->head; // Tail points back to head initially
    }

    // Method for serialization
    public function serialize()
    {
        // Serialize capacity and cache (keys and values)
        $cacheData = [];
        foreach ($this->cache as $key => $node) {
            $cacheData[$key] = $node->value;
        }

        return serialize([
            'capacity' => $this->capacity,
            'cache' => $cacheData
        ]);
    }

    // Method for deserialization
    public function unserialize($data)
    {
        $unserialized = unserialize($data);
        $this->capacity = $unserialized['capacity'];
        $this->cache = [];

        // Rebuild the doubly linked list
        $this->head = new ListNode(null, null);
        $this->tail = new ListNode(null, null);
        $this->head->next = $this->tail;
        $this->tail->prev = $this->head;

        // Restore cache by re-adding nodes to the list
        foreach ($unserialized['cache'] as $key => $value) {
            $this->put($key, $value); // Restore the key-value pairs to the cache
        }
    }

    // Get method: returns the value for the key or null if the key is not found
    public function get($key)
    {
        if (!isset($this->cache[$key])) {
            return null;
        }

        $node = $this->cache[$key];
        $this->moveToHead($node); // Move the node to the head (most recently used)

        return $node->value;
    }

    // Put method: adds or updates a key-value pair in the cache
    public function put($key, $value)
    {
        if (isset($this->cache[$key])) {
            $node = $this->cache[$key];
            $node->value = $value; // Update the value
            $this->moveToHead($node); // Move it to the head (most recently used)
        } else {
            $newNode = new ListNode($key, $value); // Create a new node
            $this->cache[$key] = $newNode;
            $this->addToHead($newNode); // Add it to the head of the list

            // If the cache exceeds its capacity, remove the least recently used item
            if (count($this->cache) > $this->capacity) {
                $tail = $this->removeTail(); // Remove the least recently used node
                unset($this->cache[$tail->key]); // Remove it from the cache array
            }
        }
    }

    // Moves a node to the head of the list (marks it as most recently used)
    private function moveToHead($node)
    {
        $this->removeNode($node); // Remove the node from its current position
        $this->addToHead($node); // Add it to the head of the list
    }

    // Adds a node to the head of the list
    private function addToHead($node)
    {
        $node->prev = $this->head;
        $node->next = $this->head->next;
        $this->head->next->prev = $node;
        $this->head->next = $node;
    }

    // Removes a node from the list
    private function removeNode($node)
    {
        $prev = $node->prev;
        $next = $node->next;
        $prev->next = $next;
        $next->prev = $prev;
    }

    // Removes the least recently used node (the node just before the tail) and returns it
    private function removeTail()
    {
        $node = $this->tail->prev; // Find the least recently used node (before the tail)
        $this->removeNode($node); // Remove it from the list
        return $node;
    }

    // Returns the current state of the cache for display purposes
    public function getCacheState()
    {
        $state = [];
        $current = $this->head->next;

        // Traverse from the head to the tail and collect all key-value pairs
        while ($current !== $this->tail) {
            $state[$current->key] = $current->value;
            $current = $current->next;
        }

        return $state;
    }
}
