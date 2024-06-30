<?php
require_once 'database.php';

function addVideo($title, $genre, $director, $release_date, $available_copies, $video_type) {
    global $conn;
    
    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO videos (title, genre, director, release_date, available_copies, video_type) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssds", $title, $genre, $director, $release_date, $available_copies, $video_type);

    // Execute the statement
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

    // Close the statement
    $stmt->close();
}

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Fetch all videos from the database
function getAllVideos($conn) {
    $sql = "SELECT title, genre, director, release_date, available_copies, video_type FROM videos";
    $result = $conn->query($sql);
    $videos = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $videos[] = $row;
        }
    }
    return $videos;
}

?>
