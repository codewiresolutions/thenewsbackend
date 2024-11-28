<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details</title>

    <!-- Google Fonts and FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* General Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #6e7dff, #42e695);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin-top: 50px;
            font-size: 3rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .category-details {
            font-size: 18px;
            color: #333;
            line-height: 1.8;
            margin-top: 30px;
        }

        .category-details .detail-row {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .category-details .detail-row:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .category-details .detail-row .label {
            font-weight: bold;
            color: #333;
            width: 120px;
        }

        .category-details .detail-row .data {
            flex: 1;
            color: #555;
        }

        /* Back Button */
        .btn-back {
            display: inline-block;
            background: linear-gradient(135deg, #6e7dff, #42e695);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            position: absolute;
            top: 20px;
            right: 20px; /* Move button to the right */
            box-shadow: 0 10px 25px rgba(66, 230, 149, 0.4);
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #42e695, #6e7dff);
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(66, 230, 149, 0.6);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                padding: 30px;
                width: 90%;
            }

            h1 {
                font-size: 2.4rem;
            }

            .category-details {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('categories.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back 
        </a>

        <h1>Category Details</h1>

        <!-- Category Details -->
        <div class="category-details">
            <div class="detail-row">
                <div class="label">ID:</div>
                <div class="data">{{ $category->id }}</div>
            </div>
            <div class="detail-row">
                <div class="label">Name:</div>
                <div class="data">{{ $category->name }}</div>
            </div>
            <div class="detail-row">
                <div class="label">Slug:</div>
                <div class="data">{{ $category->slug }}</div>
            </div>
            <div class="detail-row">
                <div class="label">State:</div>
                <div class="data">{{ $category->state ? 'Active' : 'Inactive' }}</div>
            </div>
        </div>
    </div>

</body>
</html>
