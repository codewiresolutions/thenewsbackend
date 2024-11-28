<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post List</title>

    <!-- Include FontAwesome and Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome icons -->
    <style>
        /* Add your custom styles here */
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            transform: scale(0.98);
            transition: all 0.3s ease;
        }

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
            float: right; /* Aligns the New Post button to the right */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
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

        table img {
            max-width: 50px;
            height: auto;
            border-radius: 4px;
        }

        /* Action Buttons (Edit, Delete, Detail) */
        .action-buttons {
            justify-content: space-around;
            align-items: center;
        }

        .action-buttons a,
        .action-buttons button {
            text-decoration: none;
            color: white;
            padding: 8px 15px;
            border-radius: 7px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-size: 14px;
            width: auto;
            box-shadow: 0 8px 24px rgba(66, 230, 149, 0.3);
            margin: 0 10px;
        }

        /* Edit Button */
        .edit-btn {
            background: linear-gradient(135deg, #28a745, #218838);
        }

        .edit-btn:hover {
            background: linear-gradient(135deg, #218838, #28a745);
            transform: translateY(-3px);
        }

        /* Delete Button */
        .delete-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #c82333, #dc3545);
            transform: translateY(-3px);
        }

        /* Detail Button */
        .detail-btn {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .detail-btn:hover {
            background: linear-gradient(135deg, #0056b3, #007bff);
            transform: translateY(-3px);
        }

        /* Success/Error Messages */
        .success-message, .error-message {
            text-align: center;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .success-message {
            background-color: #28a745;
            color: white;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
        }

        /* Category Filter Form */
        .filter-form {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-form select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .filter-form input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .filter-form button {
            padding: 10px 20px;
            background-color: #42e695;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 8px 24px rgba(66, 230, 149, 0.3);
        }

        .filter-form button:hover {
            background-color: #6e7dff;
        }

        /* Pagination */
        .pagination {
            text-align: center;
            margin-top: 20px;
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
        <h1>Post List</h1>

        <!-- Success or Error Message -->
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <!-- Back Button -->
        <a href="/" class="btn-back">
            <i class="fas fa-arrow-left"></i> Home
        </a>

        <!-- New Post Button -->
        <a href="{{ route('posts.create') }}" class="btn-create">
            <i class="fas fa-plus"></i> New Post
        </a>

        <!-- Category Filter and Search Form -->


        <!-- Table with Posts -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Video</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($posts->isEmpty())
                    <tr>
                        <td colspan="8" style="text-align: center;">No posts found matching the search criteria.</td>
                    </tr>
                @else
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ Str::limit($post->description, 50) }}</td>
                            <td><img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"></td>
                            <td>
                                <video width="120" height="120" controls>
                                    <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </td>


                            <td>{{ $post->status ? 'Published' : 'Draft' }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('posts.edit', $post->id) }}" class="edit-btn"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                                <a href="{{ route('posts.show', $post->id) }}" class="detail-btn"><i class="fas fa-eye"></i> View Details</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            {{ $posts->links() }}
        </div>
    </div>

</body>

</html>
