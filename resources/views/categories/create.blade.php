<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <!-- Include FontAwesome and Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome icons -->
    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #6e7dff, #42e695); /* Gradient background */
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin-top: 50px;
            font-size: 3.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            transform: scale(0.98);
            transition: all 0.3s ease;
            padding-left: 50px;
            padding-right: 50px;
        }

      

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            color: #333;
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input[type="text"], select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #ddd;
            border-radius: 10px;
            background-color: #f7f7f7;
            color: #333;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, select:focus {
            border-color: #42e695;
            background-color: #f0fdf6;
            box-shadow: 0 0 8px rgba(66, 230, 149, 0.5);
        }

        button, .btn-back {
            background: linear-gradient(135deg, #6e7dff, #42e695);
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
            width: 48%;
            box-shadow: 0 8px 24px rgba(66, 230, 149, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        button:hover, .btn-back:hover {
            background: linear-gradient(135deg, #42e695, #6e7dff);
            transform: translateY(-3px);
        }

        .btn-back {
            background-color: #607d8b;
        }

        .btn-back:hover {
            background-color: #455a64;
            transform: translateY(-3px);
        }

        .btn i {
            margin-right: 10px; /* Space between icon and text */
        }

        .error-message {
            background-color: #ffcccc;
            color: #d9534f;
            padding: 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            border: 1px solid #d9534f;
            box-shadow: 0 0 8px rgba(217, 54, 64, 0.3);
        }

        .mt-2 {
            margin-top: 12px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                padding: 30px;
            }

            label {
                font-size: 16px;
            }

            input[type="text"], select {
                font-size: 15px;
                padding: 12px;
            }

            button, .btn-back {
                width: 100%;
                padding: 14px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn-back {
                margin-bottom: 10px;
            }
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Create Category</h1>

    <!-- Display validation errors if any -->
    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <!-- Slug -->
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}" required>
        </div>

        <!-- State -->
        <div class="form-group">
            <label for="state">State</label>
            <select class="form-control" name="state" id="state" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="button-group">
            <!-- Back Button -->
            <a href="{{ route('categories.index') }}" class="btn btn-back" style="text-align: center;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <!-- Create Button -->
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Category
            </button>
        </div>
    </form>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
