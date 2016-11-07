<!DOCTYPE html>
<html lang="fa">
<head>
    <title>اشیاء پیدا شده</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="..\Css\Home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body dir="rtl">


    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="http://localhost:81">گمشدگان</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                <li><a href="http://localhost:81/View/Lost.php">اشیاء گم شده</a></li>
                <li><a href="http://Localhost:81">صفحه اصلی</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="jumbotron text-center" id="about_us">
        <h1>درباره ما</h1> 
        <p>با ما توانایی یافتن اشیاء گمشده خود را خواهید داشت.</p> 
    </div>
    <div class="container-fluid text-center">
        <?php
            $connection = new mysqli("localhost:3307", "root", "shayan", "lostandfound");
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            $result= $connection->query("CALL FoundObjects()");
            if($result->num_rows > 0)
            {
                $i = 0;
                $div = "<div class='row'><div class='col-sm-3' ></div><div class='col-sm-2'>";
                while($row = $result->fetch_assoc()) {
                    if($i%2 === 0 && $i != 0)
                    {
                        $div .= "</div><div class='row'><div class='col-sm-2'>";
                    }
                    $div .= "<div class='thumbnail'><img width='150px' height='150px' src='../Images/" . $row["Image_address"] . "' alt='Object Picture'>";
                    $div .= "<div class='caption'><p>" . $row["Description"] . "</p></div></div></div>";
                    $i++;
                }
                $div .= "<div class='col-sm-3' ></div></div>";
                echo $div;

                // $i = 0;
                // $div = "<div class='row'><table><tr>";
                // while($row = $result->fetch_assoc()) {
                //     if($i%2 === 0 && $i != 0)
                //     {
                //         $div .= "</tr><tr>";
                //     }else
                //     {
                //         $div .= "<td><div class='thumbnail'><img src='" . $row["Image_address"] . "' alt='Object Picture'>";
                //         $div .= "<div class='caption'><p>" . $row["Description"] . "</p></div></div></td>";
                //     }
                //     $i++;
                // }
                // $div .= "</tr></div>";
                // echo $div;
            }
        ?>
    </div>

    <div class="container-fluid text-center" id="contact">
        <div class="row">
            <footer>
                <p>تمامی حقوق سایت متعلق به شرکت مدیس می باشد.</p>
            </footer>
        </div>
    </div>

    


</body>
</html>