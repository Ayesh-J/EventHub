<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../users/login.php");
    exit();
}
include '../config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?php echo $_SESSION['user_name']; ?>!</p>
            <a href="../users/logout.php" class="logout-btn">Logout</a>
        </header>

        <main>
            <section class="actions">
                <a href="../actions/add_events.php" class="add-event-btn">Add Event</a>
            </section>

            <section class="event-list">
                <h2>All Events</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Venue</th>
                            <th>Organizer</th>
                            <th>Max Participants</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM events ORDER BY event_date ASC");

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['title']) . "</td>
                                        <td>" . htmlspecialchars($row['event_date']) . "</td>
                                        <td>" . htmlspecialchars($row['time']) . "</td>
                                        <td>" . htmlspecialchars($row['venue']) . "</td>
                                        <td>" . htmlspecialchars($row['organizer']) . "</td>
                                        <td>" . htmlspecialchars($row['max_participants']) . "</td>
                                        <td>
                                            <form action='../actions/delete_event.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this event?\")'>
                                                <input type='hidden' name='event_id' value='" . $row['id'] . "'>
                                                <button type='submit' class='delete-btn'>Delete</button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No events found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <section class="registration-list">
                <h2>Participant Registrations</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>College</th>
                            <th>Team Name</th>
                            <th>Participant</th>
                            <th>Members</th>
                            <th>Registered By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $registrations = $conn->query("
                            SELECT 
                                e.title AS event_title,
                                r.college_name,
                                r.team_name,
                                r.participant_name,
                                r.member_names,
                                u.name AS registered_by
                            FROM event_registrations r
                            JOIN events e ON r.event_id = e.id
                            JOIN users u ON r.user_id = u.id
                            ORDER BY e.title, r.id DESC
                        ");

                        if ($registrations && $registrations->num_rows > 0) {
                            while ($row = $registrations->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['event_title']) . "</td>
                                        <td>" . htmlspecialchars($row['college_name']) . "</td>
                                        <td>" . htmlspecialchars($row['team_name']) . "</td>
                                        <td>" . htmlspecialchars($row['participant_name']) . "</td>
                                        <td>" . htmlspecialchars($row['member_names']) . "</td>
                                        <td>" . htmlspecialchars($row['registered_by']) . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No participant registrations found.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
