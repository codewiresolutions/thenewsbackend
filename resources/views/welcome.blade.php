<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS (Optional, but recommended for modern styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* General Styling */
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #6e7fff, #7b8dff, #96b2ff);
            background-size: 400% 400%;
            animation: gradientBackground 8s ease infinite;
            margin: 0;
            padding: 0;
            color: white;
            overflow: hidden;
        }

        /* Gradient Background Animation */
        @keyframes gradientBackground {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Page Container */
        .container {
            margin-top: 100px;
            text-align: center;
            animation: slideInUp 1s ease-out; /* Animation for the container */
        }

        /* Heading Styling */
        h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 50px;
            animation: fadeInUp 3.5s ease-out;
            opacity: 0;
            transform: translateY(30px);
        }

        /* Button Styling */
        .btn {
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50px;
            text-decoration: none;
            margin: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background-color: #28a745;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #218838;
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Fancy Hover Effect */
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background-color: rgba(255, 255, 255, 0.3);
            transition: width 0.4s, height 0.4s, top 0.4s, left 0.4s;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .btn:hover::before {
            width: 0;
            height: 0;
            top: 50%;
            left: 50%;
        }

        /* Page Fade-In */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation for button slide-up */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .btn {
                width: 100%;
                padding: 18px;
            }

            h1 {
                font-size: 2rem;
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Heading with animation -->
        <h1>Welcome to the THENEWS</h1>

        <!-- Buttons to navigate to posts.index and categories.index -->
        <a href="{{ route('posts.index') }}" class="btn btn-primary">
        Posts
        </a>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Categories
        </a>
    </div>

    <!-- Optional Bootstrap JS (for better performance and interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
