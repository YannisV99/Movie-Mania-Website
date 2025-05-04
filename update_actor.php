<?php
include ('connection.php');
include ('sidenav_admin.php');
include('adminAccess.php');
mysqli_set_charset($connect, "utf8mb4");

if (isset($_GET['actor_id'])){
    $actor_id = isset($_GET['actor_id']) ? $_GET['actor_id'] : '';
    if ($actor_id) {
        $sql_actor = "SELECT * FROM actor WHERE actor_id = '$actor_id'";
    } else {
        echo "<p>No valid ID provided.</p>";
        exit;
    }
    $result_actor = mysqli_query($connect, $sql_actor);
    $actor = mysqli_fetch_assoc($result_actor);

    
    $imageData = base64_encode($actor['actor_image']);
    $imageSrc = 'data:image/jpeg;base64,' . $imageData;

    $sql_movieImage = "SELECT movie.movie_id, movie.title, movie.movie_image
                    FROM movie
                    JOIN actor_movie ON movie.movie_id = actor_movie.movie_id
                    WHERE actor_movie.actor_id = '$actor_id'";
    $result_movieImage = mysqli_query($connect, $sql_movieImage);

    
    $sql_tvshowImage = "SELECT tvshow.tvshow_id, tvshow.title, tvshow.tv_show_image
                        FROM tvshow
                        JOIN actor_tvshow ON tvshow.tvshow_id = actor_tvshow.tvshow_id
                        WHERE actor_tvshow.actor_id = '$actor_id'";
    $result_tvshowImage = mysqli_query($connect, $sql_tvshowImage);
}


if (isset($_POST['saveBtn'])) {

    // escape string prevent sql injection attacks, ex. single quote ' can break sql syntax
    $actor_name = mysqli_real_escape_string($connect, $_POST['actor-name']);
    $gender = mysqli_real_escape_string($connect, $_POST['gender']);
    $country = mysqli_real_escape_string($connect, $_POST['country']);
    $dob = mysqli_real_escape_string($connect, $_POST['dob']);
    $constellation = mysqli_real_escape_string($connect, $_POST['constellation']);
    $age = mysqli_real_escape_string($connect, $_POST['age']);
    $height = mysqli_real_escape_string($connect, $_POST['height']);
    $nationality = mysqli_real_escape_string($connect, $_POST['nationality']);
    $bio = mysqli_real_escape_string($connect, $_POST['bio']);
    
    $dobFormatted = DateTime::createFromFormat('Y-m-d', $dob);
    $currentDate = new DateTime();
    
    if (isset($_FILES['actorImage']['tmp_name']) && $_FILES['actorImage']['tmp_name'] != '') {
        $imageData = mysqli_real_escape_string($connect, file_get_contents($_FILES['actorImage']['tmp_name']));
    } else {
        
        $imageData = null;
    }

    
    $updateQuery = "UPDATE actor SET 
                    actor_name = '$actor_name', 
                    gender =  '$gender', 
                    country = '$country', 
                    date_of_birth = '$dob', 
                    constellation = '$constellation', 
                    age = '$age', 
                    height = '$height', 
                    nationality = '$nationality', 
                    bio = '$bio'";
                    

    if ($imageData !== null) {
        $updateQuery .= ", actor_image = '$imageData'"; // update img only if new img is uploaded
    }

    $updateQuery .= " WHERE actor_id = '$actor_id'";
    
    if($dobFormatted <= $currentDate){
        if (mysqli_query($connect, $updateQuery)) {
            echo "<script>
                    alert('Actor information updated successfully.');
                    window.location='update_actor.php?actor_id=".$actor_id."'; 
                </script>";
        } else {
            echo "<script>
                    alert('Failed to update actor information.');
                    window.location='update_actor.php?actor_id=".$actor_id."'; 
                </script>";
        }
    }else{
        echo "<script>
                alert('Invalid date of birth. Please enter a valid date before TODAY.');
                window.location='update_actor.php?actor_id=".$actor_id."';
              </script>";
    }
}

if(isset($_POST['deleteMovieBtn'])){
    $movie_id = $_POST['movie_id'];
    $actor_id = $actor_id;
    
    $deleteQuery = "DELETE FROM actor_movie WHERE actor_id = '$actor_id' AND movie_id = '$movie_id'"; //deletes the connection record in actor_movie table
    $deleteResult = mysqli_query($connect, $deleteQuery);
    if($deleteResult){
        echo "<script>
                alert('Movie successfully deleted.');
                window.location='update_actor.php?actor_id=".$actor_id."'; 
              </script>";
    }else {
        echo "<script>
                alert('Failed to delete movie.');
                window.location='update_actor.php?actor_id=".$actor_id."'; 
              </script>";
    }
}

if(isset($_POST['deleteTVShowBtn'])){
    $tvshow_id = $_POST['tvshow_id'];
    $actor_id = $actor_id;
    
    $deleteQuery = "DELETE FROM actor_tvshow WHERE actor_id = '$actor_id' AND tvshow_id = '$tvshow_id'"; 
    $deleteResult = mysqli_query($connect, $deleteQuery);
    if($deleteResult){
        echo "<script>
                alert('TV Show successfully deleted.');
                window.location='update_actor.php?actor_id=".$actor_id."'; 
              </script>";
    }else {
        echo "<script>
                alert('Failed to delete tv show.');
                window.location='update_actor.php?actor_id=".$actor_id."'; 
              </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Actor</title>
    <link rel="stylesheet" href="editPage.css">
</head>
<body>
    <div id="main">
        <div class="container">
            <h2>Edit Actor</h2>
            <form method="POST" enctype="multipart/form-data"> 
                <div class="nameAndPhoto">
                    <div class="photo">
                        <img id="actorImagePreview" class="photo-placeholder" src="<?php echo $imageSrc; ?>" alt="Actor Image">
                    </div>
                    
                    <div class="name-input">
                        <label for="actor-name">Name:</label>
                        <input type="text" id="actor-name" name="actor-name" value="<?php echo htmlspecialchars($actor['actor_name']); ?>" required>
                    </div>

                    <input type="file" name="actorImage" id="actorImageInput" accept="image/*" style="display: none;">
                    <button type="button" class="change-photo-btn" id="changePhotoBtn">Change Photo</button>
                </div>

                <script>
                    // referring to the change photo button and opening up a file dialog
                    document.getElementById('changePhotoBtn').addEventListener('click', function() { 
                        document.getElementById('actorImageInput').click();
                    });

                    //change event listener triggerd when user select file
                    document.getElementById('actorImageInput').addEventListener('change', function(event) {
                        const file = event.target.files[0]; //selects only the first selection if multiple imgs
                        if (file) {
                            const reader = new FileReader(); 
                            //function called when file has been read
                            reader.onload = function(e) {  
                                document.getElementById('actorImagePreview').src = e.target.result; //replaces bfr image with slcted img
                            };
                            reader.readAsDataURL(file); //convert img binary to base64 encoded content, data:image/png;base64.xxxxx
                        }
                    });
                </script>

                <div class="details">
                    <div class="left-details">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" required>
                            <option value="Male" <?php echo htmlspecialchars($actor['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo htmlspecialchars($actor['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select><br>

                        <label for="country">Country:</label>
                        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($actor['country']); ?>" required><br>

                        <label for="dob">DOB:</label>
                        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($actor['date_of_birth']); ?>" required><br>

                        <label for="constellation">Constellation:</label>
                        <select id="constellation" name="constellation" required>
                            <option value="Aries" <?php echo htmlspecialchars($actor['constellation'] == 'Aries') ? 'selected' : ''; ?>>Aries</option>
                            <option value="Taurus" <?php echo htmlspecialchars($actor['constellation'] == 'Taurus') ? 'selected' : ''; ?>>Taurus</option>
                            <option value="Gemini" <?php echo htmlspecialchars($actor['constellation'] == 'Gemini') ? 'selected' : ''; ?>>Gemini</option>
                            <option value="Cancer" <?php echo htmlspecialchars($actor['constellation'] == 'Cancer') ? 'selected' : ''; ?>>Cancer</option>
                            <option value="Leo" <?php echo htmlspecialchars($actor['constellation'] == 'Leo') ? 'selected' : ''; ?>>Leo</option>
                            <option value="Virgo" <?php echo htmlspecialchars($actor['constellation'] == 'Virgo') ? 'selected' : ''; ?>>Virgo</option>
                            <option value="Libra" <?php echo htmlspecialchars($actor['constellation'] == 'Libra') ? 'selected' : ''; ?>>Libra</option>
                            <option value="Scorpio" <?php echo htmlspecialchars($actor['constellation'] == 'Scorpio') ? 'selected' : ''; ?>>Scorpio</option>
                            <option value="Sagittarius" <?php echo htmlspecialchars($actor['constellation'] == 'Sagittarius') ? 'selected' : ''; ?>>Sagittarius</option>
                            <option value="Capricorn" <?php echo htmlspecialchars($actor['constellation'] == 'Capricorn') ? 'selected' : ''; ?>>Capricorn</option>
                            <option value="Aquarius" <?php echo htmlspecialchars($actor['constellation'] == 'Aquarius') ? 'selected' : ''; ?>>Aquarius</option>
                            <option value="Pisces" <?php echo htmlspecialchars($actor['constellation'] == 'Pisces') ? 'selected' : ''; ?>>Pisces</option>
                        </select><br>

                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($actor['age']); ?>" required><br>

                        <label for="height">Height:</label>
                        <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($actor['height']); ?>" required><br>

                        <label for="nationality">Nationality:</label>
                        <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($actor['nationality']); ?>" required>
                    </div>

                    <div class="right-details">
                        <label for="bio">Bio:</label>
                        <textarea id="bio" name="bio" rows="6" cols="30" required><?php echo htmlspecialchars($actor['bio']); ?></textarea>
                    </div>
                </div>

                <div class="buttons">
                    
                    <a href="actor_admin.php?actor_id=<?php echo $actor['actor_id']?>" class="user-view-btn">View User Page</a>
                    <input type="submit" value="Save" name="saveBtn" class="save-btn">
                </div>

                <h3>Movies and TV Shows <?php echo $actor['actor_id']?></h3>
                <div class="movies-tvshows">
                    
                    <?php
                   
                    if (mysqli_num_rows($result_movieImage) > 0) {
                        while ($movie = mysqli_fetch_assoc($result_movieImage)) {
                            $movieImageData = base64_encode($movie['movie_image']);
                            $movieImageSrc = "data:image/jpeg;base64," . $movieImageData;
                    ?>
                        <form action="" method="POST">
                            <div class="movie-box">
                                <div class="movie-image-box">
                                    <img src="<?php echo $movieImageSrc; ?>" alt="Movie Image">
                                </div>
                                <div class="movie-name">
                                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                                </div>
                                <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']?>"></input>
                                <input type="submit" class="deleteBtn" value="Delete" name="deleteMovieBtn"></input>
                            </div>
                        </form>
                    <?php
                        }
                    } else {
                        
                    }
                    ?>

                    
                    <?php
                
                    if (mysqli_num_rows($result_tvshowImage) > 0) {
                        while ($tvshow = mysqli_fetch_assoc($result_tvshowImage)) {
                            $tvshowImageData = base64_encode($tvshow['tv_show_image']);
                            $tvshowImageSrc = "data:image/jpeg;base64," . $tvshowImageData;
                    ?>
                        <form action="" method="POST">
                            <div class="tvshow-box">
                                <div class="tvshow-image-box">
                                    <img src="<?php echo $tvshowImageSrc; ?>" alt="TV Show Image">
                                </div>
                                <div class="tvshow-name">
                                    <h3><?php echo htmlspecialchars($tvshow['title']); ?></h3>
                                </div>
                                <input type="hidden" name="tvshow_id" value="<?php echo $tvshow['tvshow_id']?>"></input>
                                <input type="submit" class="deleteBtn" value="Delete" name="deleteTVShowBtn"></input>
                            </div>
                        </form>
                    <?php
                        }
                    } else {
                        
                    }
                    ?>
                    <button type="button" class="movie-box add-movie" onclick="redirectToAddMoviePage();">
                        <span>+</span>
                    </button>

                    <script>
                        function redirectToAddMoviePage() {
                            // Sir, this is Tai Zhen Zhou i couldnt find this line of code during the
                            // presentation because i was nervous please forgive me
                            // this is the button to bring the user to the page with 
                            // the function to add actor to existing movies/tvshows
                            window.location.href = 'actorAddMovieTvShow.php?actor_id=<?php echo $actor_id; ?>';
                        }
                    </script>
                </div>
                
            </form>
        </div>
        <?php include 'footer_admin.php';?>
    </div>
</body>
</html>
