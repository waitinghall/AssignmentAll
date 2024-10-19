<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LRU Cache</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <!-- Left column: forms for get and put -->
        <div class="col-md-6">
            <h3>LRU Cache</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form for inserting (put) -->
            <form action="/cache/put" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="putKey" class="form-label">Key (a-z only)</label>
                    <!-- Pattern added to restrict input to letters a-z -->
                    <input type="text" class="form-control" id="putKey" name="key" placeholder="Enter key (letters only)"
                           pattern="[a-zA-Z]+" title="Only lowercase and uppercase letters are allowed" required>
                </div>
                <div class="mb-3">
                    <label for="putValue" class="form-label">Value</label>
                    <input type="text" class="form-control" id="putValue" name="value" placeholder="Enter value" required>
                </div>
                <button type="submit" class="btn btn-primary">Add (put)</button>
            </form>

            <!-- Form for retrieving (get) -->
            <form action="/cache/get" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="getKey" class="form-label">Key (a-z only)</label>
                    <!-- Same pattern applied to the get form -->
                    <input type="text" class="form-control" id="getKey" name="key" placeholder="Enter key (letters only)"
                           pattern="[a-zA-Z]+" title="Only lowercase and uppercase letters are allowed" required>
                </div>
                <button type="submit" class="btn btn-secondary">Retrieve (get)</button>
            </form>
        </div>

        <!-- Right column: current cache state -->
        <div class="col-md-6">
            <h3>Current Cache State</h3>

            @if(!empty($cacheState))
                <ul class="list-group">
                    @foreach($cacheState as $key => $value)
                        <li class="list-group-item">
                            <strong>{{ $key }}:</strong> {{ $value }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>The cache is empty</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
