<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>

    </style>
</head>
<body>

    <header>
        <h1>Admin Dashboard</h1>
        <div>
            <a href="{{ route('home') }}" >{{ __('Books Platform') }}</a>
        </div>
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
            <div class="icon-container">
                <a href="{{ route('generatePDF') }}" target="_blank"><span class="icon pdf-icon"></span></a>
                <a href="{{ route('generateEXCEL') }}" ><span class="icon excel-icon"></span></a>
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
