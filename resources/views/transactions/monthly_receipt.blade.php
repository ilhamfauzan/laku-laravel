<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Receipt</title>
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
            }

            .receipt-container {
                width: 210mm;
                /* A4 width */
                margin: 0 auto;
                padding: 20px;
                box-sizing: border-box;
            }

            .receipt-header {
                text-align: center;
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 2px solid #000;
            }

            .summary-section {
                margin-bottom: 30px;
            }

            .transactions-section {
                margin-top: 30px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            th,
            td {
                padding: 8px;
                border: 1px solid #ddd;
            }

            th {
                background-color: #f5f5f5;
                font-weight: bold;
            }

            .summary-table th {
                text-align: left;
            }

            .transactions-table td {
                font-size: 14px;
            }

            .section-title {
                font-size: 18px;
                font-weight: bold;
                margin: 20px 0 10px 0;
                padding-bottom: 5px;
                border-bottom: 1px solid #ddd;
            }

            .totals {
                margin-top: 20px;
                text-align: right;
                font-weight: bold;
            }

            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h2>Monthly Receipt Report</h2>
            <p><strong>Month:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</p>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="section-title">Monthly Summary</div>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Service Type</th>
                        <th>Total Transactions</th>
                        <th>Total Weight (kg)</th>
                        <th>Total Revenue (Rp)</th>
                        <th>Average per Transaction (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summary as $service => $data)
                        <tr>
                            <td>{{ $service }}</td>
                            <td>{{ $data['transactions'] }}</td>
                            <td>{{ number_format($data['total_weight'], 2, ',', '.') }}</td>
                            <td>{{ number_format($data['total_cost'], 0, ',', '.') }}</td>
                            <td>{{ number_format($data['total_cost'] / $data['transactions'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="totals">
                            Total Revenue: Rp {{ number_format($summary->sum('total_cost'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Transactions Section -->
        <div class="transactions-section">
            <div class="section-title">Transaction Details</div>
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Weight</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions->sortBy('payment_date') as $transaction)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->payment_date)->format('d/m/Y') }}</td>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->laundry->customer_name }}</td>
                            <td>{{ $transaction->laundry->service->service_name }}</td>
                            <td>{{ number_format($transaction->laundry->laundry_weight, 2, ',', '.') }} kg</td>
                            <td>{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="receipt-footer">
            <p>Report generated on: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>

</html>
