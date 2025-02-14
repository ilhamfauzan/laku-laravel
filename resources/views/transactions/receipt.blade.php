{{-- filepath: /C:/laragon/www/laundryku/resources/views/transactions/receipt.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
            }

            .receipt-container {
                width: 80mm;
                /* Small receipt width */
                margin: 0 auto;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-sizing: border-box;
            }

            .receipt-header {
                text-align: center;
                margin-bottom: 10px;
            }

            .receipt-details {
                margin-bottom: 10px;
            }

            .receipt-footer {
                text-align: center;
                margin-top: 10px;
            }

            .receipt-container {
                page-break-after: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <br>
            <h2>Laundry Receipt</h2>
            <br>
        </div>
        <div class="receipt-details">
            <p style="text-align: center">===================================</p>
            <p style="text-align: center"><b>ID:</b> {{ $transaction->id }} || <b>Cashier:</b> {{ Auth::user()->name }}
            </p>
            <p style="text-align: center">===================================</p>
            <br>
            <table style="margin: 0 auto;">
                <tr>
                    <td style="text-align: right"><strong>Customer Name:</strong></td>
                    <td style="text-align: left">{{ $transaction->laundry->customer_name }}</td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Phone Number:</strong></td>
                    <td style="text-align: left">
                        {{ substr($transaction->laundry->customer_phone_number, 0, 3) . '*******' . substr($transaction->laundry->customer_phone_number, -4) }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Service:</strong></td>
                    <td style="text-align: left">{{ $transaction->laundry->service->service_name }}</td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Weight:</strong></td>
                    <td style="text-align: left">{{ $transaction->laundry->laundry_weight }} kg</td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Total Cost:</strong></td>
                    <td style="text-align: left">{{ $transaction->formatted_total_price }}</td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Payment Date:</strong></td>
                    <td style="text-align: left">{{ $transaction->formatted_payment_date }}</td>
                </tr>
                <tr>
                    <td style="text-align: right"><strong>Description:</strong></td>
                    <td style="text-align: left">{{ $transaction->laundry->description }}</td>
                </tr>
            </table>
        </div>
        <style>
            .receipt-details p {
                margin: 5px 0;
                font-size: 14px;
            }

            .receipt-details p strong {
                display: inline-block;
                width: 120px;
            }
        </style>
        <div class="receipt-footer">
            <p>===============================</p>
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>

</html>
