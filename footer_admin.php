<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <title></title>
    <style>
        body {
            scroll-behavior: smooth;
            font-family: "Lato", sans-serif;
            margin:0;
            padding:0;
            transition: background-color .5s;
            min-height: 100vh; 
            height: 100%;
        }

        #footer{
            background-color: #000000;
            color:white;
            width: 100%;
            padding:40px;
            padding-bottom: 20px;
            bottom:0;
            margin-top:120px;
            position: relative;
        }

        #footer img{
            margin-bottom: 20px;
        }

        #footer p{
            text-align: center;
        }

        #footer a{
            text-decoration: none;
            color:white;
            font-size: 16px;
            display: block;
            margin-bottom:20px
        }

        #footer a:hover{
            text-decoration: underline;
        }

        .footer-content{
            display: flex;
            text-align: left;
        }

        #footer table{
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            margin-left:10px;
        }

        #footer table th{
            padding-bottom:20px;
            font-size: 20px;
        }

        #footer-image{
            display:block;
            height:40px;
            width:40px;
            border-radius: 50%;
            margin-left:10px;
        }

        .footer-logo{
            height:50px;
            width:250px;
        }
    </style>
</head>
<body>
    <div id="footer">
        <img src="images/moviemanialogo.png" alt="movie mania logo" class="footer-logo">
        <table>
            <tr>
                <th colspan="3">Explore</th>
                <th>Contact Us</th>
            </tr>
            <tr>
                <td><a href="home_admin.php">Home</a></td>
                <td><a href="news.php">News</a></td>
                <td><a href="profile.php">Profile</a></td>
                <td rowspan="2">
                    <div class="footer-content">
                        <a href="https://www.instagram.com/" target="_blank"><img src="images/instagram.png" id="footer-image"></a>
                        <a href="https://www.facebook.com/" target="_blank"><img src="images/facebook.png" id="footer-image"></a>
                        <a href="https://mail.google.com/" target="_blank"><img src="images/email.png" id="footer-image"></a>
                    </div>
                </td>
            </tr>
            <tr>
                <td><a href="movies_admin.php">Movies</a></td>
                <td><a href="faq_admin.php">FAQ</a></td>
                
                
            </tr>
            <tr>
                <td><a href="tvshow_admin.php">TV Shows</a></td>
                <td><a href="aboutus.php">About Us</a></td>
            </tr>
        </table>
        <hr>
        <p>© 2024 MovieMania. Privacy </p>
    </div>
</body>
</html>