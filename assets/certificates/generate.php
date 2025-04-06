<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "eventhub");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch certificate details
$cert_id = 1; // You can use $_GET['id'] if you want dynamic generation
$sql = "SELECT c.*, u.name AS user_name, e.title AS event_title
        FROM certificates c
        JOIN users u ON c.user_id = u.id
        JOIN events e ON c.event_id = e.id
        WHERE c.id = $cert_id";

$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['user_name'];
    $event = $row['event_title'];
    $filename = $row['certificate_link'];

    // Load the certificate template
    $image = imagecreatefrompng("assets/certificate_bg.png");

    // Set font and colors
    $black = imagecolorallocate($image, 0, 0, 0);
    $font = __DIR__ . '/assets/GreatVibes-Regular.ttf'; // Change to your TTF file

    // Name placement (adjust X/Y and font size as needed)
    imagettftext($image, 40, 0, 320, 310, $black, $font, $name);
    imagettftext($image, 24, 0, 320, 370, $black, $font, "for participating in $event");

    // Save the certificate
    imagepng($image, $filename);
    imagedestroy($image);

    echo "Certificate generated successfully at: <a href='$filename' target='_blank'>$filename</a>";
} else {
    echo "Certificate not found.";
}

$conn->close();
?>
