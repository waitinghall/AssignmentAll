
# LRU Cache Project

This project implements an LRU (Least Recently Used) cache using PHP (Laravel) and Redis. The cache stores key-value pairs and supports operations to retrieve and insert new values. It also evicts the least recently used item when the cache exceeds its defined capacity.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
    - [Available Endpoints](#available-endpoints)
    - [Operations](#operations)
- [Testing](#testing)
- [Technology Stack](#technology-stack)
- [License](#license)

## Installation

### Requirements:
- **Docker & Docker Compose** (to run Redis, Laravel, etc.)

### Repository location:
Repository location:
   ```bash
   git clone https://github.com/waitinghall/Assignment.git
   cd <repository-folder>
   ```

### Access the application at:
Add to your local hosts file the following line:
   ```
   127.0.0.1 oktopost.com
   ```
URL    
   ```
   http://oktopost.com/cache
   ```

## Usage

### Available Endpoints

1. **`GET /cache`**: Displays the cache form and the current state of the cache.
2. **`POST /cache/put`**: Adds or updates a key-value pair in the cache. If the cache exceeds its capacity, it evicts the least recently used item.
    - **Parameters**:
        - `key`: A string containing letters (`a-z`, `A-Z`).
        - `value`: A string value associated with the key.
3. **`POST /cache/get`**: Retrieves the value for the specified key. If the key is found, it is moved to the top of the cache (most recently used).
    - **Parameters**:
        - `key`: A string key to retrieve its value from the cache.

### Operations

- **PUT (Insert/Update)**:
    - Adds or updates a key-value pair in the cache.
    - If the cache is full, the least recently used (LRU) item is evicted.
    - After insertion, the key is marked as the most recently used.

- **GET (Retrieve)**:
    - Retrieves a value for a given key.
    - Moves the retrieved key to the top of the cache (most recently used).
    - If the key is not found, returns `null`.

### Example Workflow:

1. **Add a key-value pair**:
    - `PUT /cache/put` with `key: a` and `value: 1`
    - The cache now contains: `a => 1`

2. **Add more values**:
    - `PUT /cache/put` with `key: b`, `value: 2` and `key: c`, `value: 3`
    - The cache state becomes: `a => 1, b => 2, c => 3`

3. **Access an existing key**:
    - `GET /cache/get` with `key: b`
    - Key `b` is moved to the top of the cache (most recently used).

4. **Add a new key (eviction)**:
    - `PUT /cache/put` with `key: d`, `value: 4` (when cache is full)
    - The least recently used key (`a`) is evicted, and the new state is: `b => 2, c => 3, d => 4`

## Testing

### Running Unit Tests
This project includes unit tests to validate the LRU cache functionality. To run the tests:

```bash
php artisan test
```

### Test Coverage:
1. **Basic Functionality Tests**:
    - Insertion (`put`) and retrieval (`get`) operations.
    - LRU eviction logic when the cache reaches its capacity.

2. **Update Existing Key**:
    - Tests whether the cache updates existing keys and moves them to the top.

3. **Edge Cases**:
    - Handling of non-existing keys and cache overflow.

### Example Test Cases:

- **Test Case 1**:
    - Insert three key-value pairs, retrieve one, and insert a fourth, ensuring the least recently used key is evicted.

- **Test Case 2**:
    - Test that calling `get()` on a key updates its usage priority in the cache.

## Technology Stack

- **Backend**: Laravel (PHP)
- **Cache**: Redis
- **Frontend**: Bootstrap for basic styling of forms.
- **Testing**: PHPUnit (for unit tests)
- **Docker**: For containerized Redis and Laravel environment.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
