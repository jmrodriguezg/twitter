<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/site/twitter/styles.css">
    <title>Twitter</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="http://localhost/site/twitter/index.php">Twitter</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="?page=timeline">Your Timeline</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=yourtweets">Your Tweets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=publicprofiles">Public Profiles</a>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0">
                <?php if (isset($_SESSION['id'])) { ?>

                    <a class="btn btn-outline-success my-2 my-sm-0" href="?function=logout">Logout</a>

                <?php } else { ?>

                    <button class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#myModal">Login/Signup</button>

                <?php } ?>
            </div>
        </div>
    </nav>