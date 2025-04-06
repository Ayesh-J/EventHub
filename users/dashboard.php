<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch all events
$eventsQuery = $conn->query("SELECT * FROM events");

// Fetch registered events
$registeredEventsQuery = $conn->prepare("
    SELECT e.id, e.title, e.event_date, e.time, e.venue, e.organizer
    FROM events e
    INNER JOIN event_registrations r ON e.id = r.event_id
    WHERE r.user_id = ?
");
$registeredEventsQuery->bind_param("i", $user_id);
$registeredEventsQuery->execute();
$registeredEvents = $registeredEventsQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/css/user.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </header>

        <main>
            <section class="available-events">
                <h2>Available Events</h2>
                <?php if ($eventsQuery->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Venue</th>
                                <th>Organizer</th>
                                <th>Register</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($event = $eventsQuery->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                                    <td><?php echo htmlspecialchars($event['time']); ?></td>
                                    <td><?php echo htmlspecialchars($event['venue']); ?></td>
                                    <td><?php echo htmlspecialchars($event['organizer']); ?></td>
                                    <td>
                                        <form action="../actions/register_event.php" method="post">
                                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                            <input type="text" name="college_name" placeholder="College Name" required>
                                            <input type="text" name="team_name" placeholder="Team Name" required>
                                            <input type="text" name="participant_name" placeholder="Your Name" required>
                                            <input type="text" name="member_names" placeholder="Team Member Names" required>
                                            <button type="submit">Register</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No events found.</p>
                <?php endif; ?>
            </section>

            <section class="registered-events">
                <h2>Your Registered Events</h2>
                <?php if ($registeredEvents->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Venue</th>
                                <th>Organizer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($event = $registeredEvents->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                                    <td><?php echo htmlspecialchars($event['time']); ?></td>
                                    <td><?php echo htmlspecialchars($event['venue']); ?></td>
                                    <td><?php echo htmlspecialchars($event['organizer']); ?></td>
                                    <td>
                                        <form action="../actions/cancel_registration.php" method="post" onsubmit="return confirm('Are you sure you want to cancel your registration?');">
                                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                            <button type="submit" class="cancel-btn">Cancel</button>
                                        </form>
                                    </td>
                                    <td data-label="Title"><?php echo htmlspecialchars($event['title']); ?></td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You haven’t registered for any events yet.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>
