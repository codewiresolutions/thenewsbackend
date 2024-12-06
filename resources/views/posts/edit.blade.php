<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
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

        input[type="text"], input[type="url"], input[type="file"], select, textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #ddd;
            border-radius: 10px;
            background-color: #f7f7f7;
            color: #333;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="file"], select {
            padding: 12px;
        }

        input[type="text"]:focus, input[type="file"]:focus, select:focus, textarea:focus {
            border-color: #42e695;
            background-color: #f0fdf6;
            box-shadow: 0 0 8px rgba(66, 230, 149, 0.5);
        }

        input[type="text"]:focus {
            background-color: #e8f7f3; /* Change background color on focus for title */
        }

        textarea {
            resize: vertical;
            height: 160px;
        }

        .image-preview {
            margin-top: 12px;
            max-width: 100%;
            max-height: 120px;
            object-fit: cover;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .image-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #6e7dff, #42e695);
            color: #fff;
            padding: 14px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(66, 230, 149, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn:hover {
            background: linear-gradient(135deg, #42e695, #6e7dff);
            transform: translateY(-3px);
        }

        .btn-secondary {
            background-color: #f44336;
        }

        .btn-secondary:hover {
            background-color: #e41f1f;
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

        .mt-2 {
            margin-top: 12px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-back, .btn-update {
            padding: 14px 20px;
            border: none;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            font-size: 16px;
            width: 48%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-back {
            background-color: #607d8b;
        }

        .btn-back:hover {
            background-color: #455a64;
            transform: translateY(-3px);
        }

        .btn-update {
            background: linear-gradient(135deg, #6e7dff, #42e695);
        }

        .btn-update:hover {
            background: linear-gradient(135deg, #42e695, #6e7dff);
            transform: translateY(-3px);
        }

        .btn i {
            margin-right: 10px; /* Space between icon and text */
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                padding: 30px;
            }

            label {
                font-size: 16px;
            }

            input[type="text"], input[type="url"], input[type="file"], select, textarea {
                font-size: 15px;
                padding: 12px;
            }

            .btn, .btn-back, .btn-update {
                padding: 14px;
                width: 100%;
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
    <h1>Edit Post</h1>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" required>{{ old('description', $post->description) }}</textarea>
        </div>

        <!-- Image -->
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" accept="image/*">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="image-preview" alt="Current Image">
            @endif
        </div>

        <!-- Video Upload -->
        <div class="form-group">
            <label for="video">Upload Video:</label>
            <input type="file" name="video" accept="video/*">

            @if ($post->video)
                <div class="mt-2">
                    <label>Current Video:</label>
                    <video width="320" height="240" controls>
                        <source src="{{ Storage::url($post->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @endif
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" required>
                <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="button-group">
            <a href="{{ route('posts.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button type="submit" class="btn-update">
                <i class="fas fa-save"></i> Update
            </button>
        </div>
    </form>
</div>

</body>
</html>
