<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>

    <!-- Google Fonts and FontAwesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome icons -->

    <!-- Custom Styles -->
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
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            transform: scale(0.98);
            transition: all 0.3s ease;
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

        button {
            background: linear-gradient(135deg, #6e7dff, #42e695);
            color: #fff;
            padding: 14px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(66, 230, 149, 0.3);
        }

        button:hover {
            background: linear-gradient(135deg, #42e695, #6e7dff);
            transform: translateY(-3px);
        }

        .btn-secondary {
            background-color: #607d8b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #455a64;
            transform: translateY(-3px);
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

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-group a {
            width: 48%;
        }

        .button-group button {
            width: 48%;
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

            button {
                padding: 14px;
            }

            .button-group {
                flex-direction: column;
            }

            .button-group a {
                margin-bottom: 10px;
            }
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Edit Category</h1>

    <!-- Display Validation Errors if Any -->
    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to Edit the Category -->
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <!-- Slug Field -->
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" name="slug" value="{{ old('slug', $category->slug) }}" required>
        </div>

        <!-- State Field -->
        <div class="form-group">
            <label for="state">State</label>
            <select class="form-control" name="state" required>
                <option value="1" {{ $category->state == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $category->state == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Button Group with Back and Update Buttons -->
        <div class="button-group">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary" style="background-color: #607d8b; color: white; display: flex; align-items: center; justify-content: center; padding: 14px 20px; border: none; border-radius: 50px; cursor: pointer; font-size: 18px; width: 100%; transition: all 0.3s ease; box-shadow: 0 8px 24px rgba(66, 230, 149, 0.3);">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Back
            </a>
            
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Update
            </button>
        </div>
    </form>
</div>

</body>
</html>
