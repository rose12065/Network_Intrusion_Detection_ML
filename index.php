<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intrusion Detection Project</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your custom CSS styles here -->
    <link rel="stylesheet" href="styles.css">
    <style>
        body{
            background-image: url(images/background.webp);
            background-repeat: no-repeat;
            background-size: cover;
        }
       
        #about {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Set the height to occupy the entire viewport height */
        }

        /* Optional styles for better presentation */
        .container {
            background-color: rgba(255, 255, 255, 0.478);
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .button {
    display: inline-block;
    padding: 10px 20px; /* Adjust padding to your liking */
    background-color: #3498db; /* Button background color */
    color: #ffffff; /* Button text color */
    text-decoration: none; /* Remove underline by default for links */
    border: none; /* Remove button border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Show a pointer cursor on hover */
    transition: background-color 0.3s, color 0.3s; /* Smooth transition on hover */
}

/* Hover effect - change background and text color */
.button:hover {
    background-color: #2980b9; /* New background color on hover */
    color: #ffffff; /* New text color on hover */
}

/* Additional styles for different button states (e.g., active, disabled) */
.button:active {
    background-color: #1c6ea4; /* Background color when button is clicked/active */
}

.button:disabled {
    background-color: #cccccc; /* Background color when button is disabled */
    color: #999999; /* Text color when button is disabled */
    cursor: not-allowed; /* Show a "not-allowed" cursor on disabled button */
}

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Network Intrusion Detection System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#resources">Resources</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contact">Contact</a>
            </li>
        </ul>
    </div>
</nav>

<div id="about" >
    <div class="container">
        <h2>File Upload</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="uploadFile">Upload a network traffic file:</label>
        <input type="file" name="uploadFile" id="uploadFile" required><br><br>
        <input type="submit" class="button" value="Upload and Analyze">
    </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

