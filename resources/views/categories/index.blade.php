<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>

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
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            transform: scale(0.98);
            transition: all 0.3s ease;
        }

        /* Button styles for Back and New Category */
        .btn-back, .btn-create {
            display: inline-block;
            background: linear-gradient(135deg, #6e7dff, #42e695);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(66, 230, 149, 0.3);
        }

        .btn-back:hover, .btn-create:hover {
            background: linear-gradient(135deg, #42e695, #6e7dff);
            transform: translateY(-3px);
        }

        .btn-back {
            float: left; /* Aligns the Back button to the left */
        }

        .btn-create {
            float: right; /* Aligns the New Category button to the right */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            font-size: 16px;
            color: #333;
        }

        table td {
            font-size: 14px;
        }

        /* Action Buttons (Aligned to the Left with space) */
        .action-buttons {
            display: flex;
            justify-content: flex-start; /* Align to the left */
            gap: 10px; /* Add 10px space between buttons */
            align-items: center;
        }

        .action-buttons a,
        .action-buttons button {
            text-decoration: none;
            color: #fff;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
            width: auto;
        }

        .edit-btn {
            background-color: #28a745;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .show-btn {
            background-color: #007bff;
        }

        .show-btn:hover {
            background-color: #0056b3;
        }

        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 20px;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                padding: 30px;
            }

            h1 {
                font-size: 2rem;
            }

            .btn-create {
                padding: 12px 18px;
                font-size: 15px;
            }

            table td {
                font-size: 13px;
            }

            table th {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Categories</h1>

        <!-- Success or Error Message -->
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <!-- Back Button -->
        <a href="/" class="btn-back">
            <i class="fas fa-arrow-left"></i>  Home
        </a>

        <!-- New Category Button -->
        <a href="{{ route('categories.create') }}" class="btn-create">
            <i class="fas fa-plus"></i> New Category
        </a>

        <!-- Table with Categories -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>State</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->state ? 'Active' : 'Inactive' }}</td>
                        <td class="action-buttons">
                            <!-- Show Button -->
                            <a href="{{ route('categories.show', $category->id) }}" class="show-btn">
                                <i class="fas fa-eye"></i> Show
                            </a>
                            <!-- Edit Button -->
                            <a href="{{ route('categories.edit', $category->id) }}" class="edit-btn">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <!-- Delete Form -->
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
