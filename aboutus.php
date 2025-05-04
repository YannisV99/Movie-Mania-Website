<?php 
    include ('loginAccess.php');
    if($_SESSION['role'] == 'admin'){
        include 'sidenav_admin.php' ;
    }else if($_SESSION['role'] == 'user'){
        include 'sidenav.php' ;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Lato", sans-serif;
            background: #000;
            color: #fff;
            background: linear-gradient(to top, #010159, #000000);
            scroll-behavior: smooth;
            height: auto;
            margin: 0;
            padding: 0;
            transition: background-color .5s;
            background-repeat: no-repeat;
            background-size: cover; 
            background-attachment: fixed; 
        }

        table{
            width: 100%;
            text-align:center;
        }

        table img{
            width: 150px;
            height:150px;
            object-fit: cover;
            object-position: center;
            border-radius:50%;
        }

        h1{
            text-align:center;
            margin: 20px auto;
        }

    </style>
</head>
<body>

    <div id="main">
        <h1>About Us</h1>
        <table>
            <tr>
                <td><img src="images/WongWanYin.jpeg" alt="Wong Wan Yin"></td>
                <td>Wong Wan Yin</td>
                <td>TP074582</td>
                <td>Team Leader</td>
            </tr>
            <tr>
                <td><img src="images/TanJunEng.jpeg" alt="Tan Jun Eng"></td>
                <td>Tan Jun Eng</td>
                <td>TP074622</td>
                <td>Team Member</td>
            </tr>
            <tr>
                <td><img src="images/VooZiYng.JPG" alt="Voo Zi Yng"></td>
                <td>Voo Zi Yng</td>
                <td>TP065589</td>
                <td>Team Member</td>
            </tr>
            <tr>
                <td><img src="images/TaiZhenZhou.jpg" alt="Tai Zhen Zhou"></td>
                <td>Tai Zhen Zhou</td>
                <td>TP073530</td>
                <td>Team Member</td>
            </tr>
            <tr>
                <td><img src="images/WongKarYi.jpeg" alt="Wong Kar Yi"></td>
                <td>Wong Kar Yi</td>
                <td>TP073612</td>
                <td>Team Member</td>
            </tr>
        </table>
        <?php if($_SESSION['role'] == 'admin'){
            include('footer_admin.php');
        }else if($_SESSION['role'] == 'user'){
            include('footer.php');
        } ?>
    </div>
</body>
</html>