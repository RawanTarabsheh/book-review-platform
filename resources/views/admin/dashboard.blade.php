<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
        }

        .sidebar {
            width: 250px;
            background-color: #222;
            color: white;
            padding: 20px;
        }

        .content {
            flex: 1;
            padding: 20px;
            background-color: white;
        }

        .stats-section {
            margin-bottom: 30px;
        }

        .stats-box {
            background-color: #3498db;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 10px;
            border-radius: 5px;
        }

        .activity-section {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }

        .user-activity {
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>

    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <div class="container">

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Add navigation links or other sidebar content here -->
            <p>Sidebar Content</p>
            <p>users</p>
            <p>books</p>
        </div>

        <!-- Content Area -->
        <div class="content">

            <!-- Site Statistics Section -->
            <div class="stats-section">
                <h2>Site Statistics</h2>
                <div class="stats-box">Total Users: {{ (isset($userCount))?$userCount :0 }}</div>
                <div class="stats-box">Total Books: {{ (isset($bookCount)) ? $bookCount :0}}</div>
                <div class="stats-box">Total reviews: {{ (isset($reviewCount)) ? $reviewCount :0}}</div>

                <!-- Add more statistics boxes as needed -->
            </div>

            <!-- User Activity Monitoring Section -->
            <div class="activity-section">
                <h2>User Activity Monitoring</h2>

                <!-- Recent User Activity Table -->
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Action</th>
                            <th>comment</th>
                            <th>Last Logged In</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userActivity as $activity )
                        <tr>
                            <td>{{ $activity->user->name }}</td>
                            <td>{{ $activity->user->email }}</td>
                            <td>Book Reviewed Since {{ $activity->user->created_at->diffForHumans()}}</td>
                            <td>{{ $activity->comment }}</td>
                            <td>{{ $activity->user->last_login_at->diffForHumans()  ??'N/A'}}</td>
                        </tr>
                        @empty
                            <span>No </span>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>

    </div>

</body>
</html>
