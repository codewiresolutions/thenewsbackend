<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Post Detail</title>

    <!-- Include FontAwesome and Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
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
            margin: 50px auto;
            padding: 50px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        /* Back Button */
        .btn-back {
            display: inline-block;
            background: linear-gradient(135deg, #6e7dff, #42e695);
            color: white;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            box-shadow: 0 10px 25px rgba(66, 230, 149, 0.4);
            position: absolute;
            top: 20px;
            right: 20px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #42e695, #6e7dff);
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(66, 230, 149, 0.6);
        }

        /* Post Details */
        .post-details {
            display: flex;
            flex-direction: column;
            gap: 25px;
            font-size: 18px;
            color: #555;
            line-height: 1.8;
            margin-top: 40px;
        }

        .post-details .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .post-details .detail-row:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .post-details .detail-row .label {
            font-weight: bold;
            color: #333;
            width: 150px;
            font-family: 'Montserrat', sans-serif;
        }

        .post-details .detail-row .data {
            flex: 1;
            color: #555;
        }

        /* Image and Video Styling */
        .post-details img,
        .post-details video {
            max-width: 30%;  /* Adjusted to give more prominence */
            width: auto;
            height: auto;
            border-radius: 15px;
            margin-top: 20px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .post-details img:hover,
        .post-details video:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Success/Error Messages */
        .success-message,
        .error-message {
            text-align: center;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .success-message {
            background-color: #28a745;
            color: white;
            border-left: 6px solid #218838;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
            border-left: 6px solid #c82333;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                padding: 30px;
                width: 90%;
            }

            h1 {
                font-size: 2.6rem;
            }

            .btn-back {
                padding: 12px 28px;
                font-size: 16px;
                top: 10px;
                right: 10px;
            }

            .post-details {
                font-size: 16px;
            }

            .post-details img,
            .post-details video {
                max-width: 100%;
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('posts.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back 
        </a>

        <h1>{{ $post->title }}</h1>

        <!-- Success or Error Message -->
        @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
        @elseif(session('error'))
        <div class="error-message">{{ session('error') }}</div>
        @endif

        <!-- Post Details -->
        <div class="post-details">
            <div class="detail-row">
                <div class="label">Post ID:</div>
                <div class="data">{{ $post->id }}</div>
            </div>
            <div class="detail-row">
                <div class="label">Category:</div>
                <div class="data">{{ $post->category->name }}</div>
            </div>
            <div class="detail-row">
                <div class="label">Description:</div>
                <div class="data">{{ $post->description }}</div>
            </div>

            <!-- Image Section -->
            <div class="detail-row">
                <div class="label">Image:</div>
                <div class="data">
                    @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Image">
                    @else
                    <p>No Image Available</p>
                    @endif
                </div>
            </div>

            <!-- Video Section -->
            <div class="detail-row">
                <div class="label">Video:</div>
                <div class="data">
                    @if($post->video)
                    <video controls>
                        <source src="{{ asset('storage/videos/' . basename($post->video)) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    @else
                    <p>No Video Available</p>
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Status:</div>
                <div class="data">{{ $post->status ? 'Active' : 'Inactive' }}</div>
            </div>
        </div>

    </div>

</body>

</html>
