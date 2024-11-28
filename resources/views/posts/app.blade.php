
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
</head>
<body>

    <!-- Header section -->
    <header>
        <nav>
            <a href="{{ route('posts.twoindex') }}">All Posts</a> |
            <a href="{{ route('posts.twocreate') }}">Create Post</a>
        </nav>
    </header>

    <!-- Main content section -->
    <div class="container">
        @yield('content')  <!-- This is where child views will inject content -->
    </div>

    <!-- Footer section -->
    <footer>
        <p>&copy; 2024 My Laravel App</p>
    </footer>

</body>
</html>
