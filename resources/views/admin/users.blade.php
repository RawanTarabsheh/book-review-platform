<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>

<body>

    <header>
        <h1>Admin Dashboard</h1>
        <div>
            <a href="{{ route('home') }}">{{ __('Books Platform') }}</a>
        </div>
    </header>

    <div class="container">

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Add navigation links or other sidebar content here -->
            <p>Sidebar</p>
            <a href="{{ route('dashboard') }}">dashboard</a>
            <a href="{{ route('getUsers') }}">users</a>
        </div>

        <!-- Content Area -->
        <div class="content">

            <!-- Site Statistics Section -->
            <div class="stats-section">
                <h2>Users</h2>

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
                            <th>Num reviews</th>
                            <th>Last Logged In</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ($user->reviews) ? $user->reviews->count(): 0  }}</td>
                                <td>{{ (isset($user->last_login_at)) ? $user->last_login_at->diffForHumans() ?? 'N/A' :'N/A' }}</td>
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
