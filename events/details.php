<?php
session_start();
include '../config/db.php';


if(!isset($_SESSION['user_id'])){
    header('Location: ../users/login.php');
    exit();
}

$event_id = $_GET['id'] ?? null;
if(!event_id){
    echo "<script>alert('Invalid Event)</script>";
    exit();
}

//fetching event details
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            Event registration
        </title>
    </head>

    <body>
        <h2><?php echo htmlspecialchars($event['title']);?></h2>
        <p><?php echo htmlspecialchars($event['description']);?></p>


        <!-- resgitration form  -->
         <form action="../actions/register_event.php" method="POST">
            <input type="hidden" name="event_id" value="<?php echo $event_id;?>">
            <button type="submit"> Register for Event</button>
         </form>

         <button > <a href="../users/dashboard.php"> Back to Dashboard</a> </button>
    </body>
</html>