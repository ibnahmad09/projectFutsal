<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $report->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2d3748; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f7fafc; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>{{ $report->title }}</h1>
    <p>Periode: {{ $report->start_date->format('d M Y') }} - {{ $report->end_date->format('d M Y') }}</p>

    @if($report->type === 'financial')
        <h2>Financial Summary</h2>
        <table>
            <tr>
                <th>Total Revenue (Online + Manual)</th>
                <td class="text-right">Rp{{ number_format($data['total_revenue'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Pendapatan Online</th>
                <td class="text-right">Rp{{ number_format($data['online_revenue'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Pendapatan Manual</th>
                <td class="text-right">Rp{{ number_format($data['manual_revenue'], 0, ',', '.') }}</td>
            </tr>
            @foreach($data['payment_statuses'] as $status => $count)
            <tr>
                <th>{{ ucfirst($status) }} Transactions</th>
                <td class="text-right">{{ $count }}</td>
            </tr>
            @endforeach
        </table>

        <h2>Transaction Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th class="text-right">Amount</th>
                    <th>Status</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['transactions'] as $transaction)
                <tr>
                    <td>{{ $transaction->payment_date->format('d M Y') }}</td>
                    <td class="text-right">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaction->status) }}</td>
                    <td>{{ isset($transaction->is_manual) ? 'Manual' : 'Online' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($report->type === 'booking')
        <h2>Booking Summary</h2>
        <table>
            <tr>
                <th>Total Bookings</th>
                <td class="text-right">{{ $data['total_bookings'] }}</td>
            </tr>
            <tr>
                <th>Most Popular Field</th>
                <td>{{ $data['most_popular_field'] }}</td>
            </tr>
            <tr>
                <th>Total Revenue</th>
                <td class="text-right">Rp{{ number_format($data['total_revenue'], 0, ',', '.') }}</td>
            </tr>
        </table>
    @endif

    @if($report->type === 'user')
        <h2>User Summary</h2>
        <table>
            <tr>
                <th>Total Users</th>
                <td class="text-right">{{ $data['total_users'] }}</td>
            </tr>
            <tr>
                <th>New Users</th>
                <td class="text-right">{{ $data['new_users'] }}</td>
            </tr>
            <tr>
                <th>Active Users</th>
                <td class="text-right">{{ $data['active_users'] }}</td>
            </tr>
        </table>
    @endif

    <!-- Add similar sections for booking and user reports -->
</body>
</html>