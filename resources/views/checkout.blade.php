<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container */
        .container {
            max-width: 400px;
            width: 100%;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Form Title */
        .payment-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form Styles */
        .payment-form form {
            display: flex;
            flex-direction: column;
        }

        .payment-form label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .payment-form input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .payment-form input:focus {
            border-color: #4caf50;
            outline: none;
        }

        .payment-form button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .payment-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Booking Details -->
        <div class="booking-details">
            <h3>Booking Details</h3>
            <p><strong>Name:</strong> {{ $booking->name }}</p>
            <p><strong>Email:</strong> {{ $booking->email }}</p>
            <p><strong>Phone:</strong> {{ $booking->number_phone }}</p>
            <p><strong>Package Name:</strong> {{ $booking->travel_package->location }}</p>
            <p><strong>Date:</strong> {{ $booking->date }}</p>
            <p><strong>Total Price:</strong> Rp{{ number_format($booking->travel_package->price) }}</p>
        </div>

        <!-- Payment Form -->
        <div class="payment-form">
            <h2>Checkout</h2>
            <form id="payment-form">
                @csrf
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Nama Anda" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email Anda" required>

                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" placeholder="Nomor Anda" required>

                <label for="amount">Amount</label>
                <input type="number" id="amount" name="amount" placeholder="100000" required>

                <button type="button" id="pay-button">Pay Now</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function() {
            // Ambil data dari form
            const form = document.getElementById('payment-form');
            const formData = new FormData(form);

            // Kirim data ke server untuk mendapatkan Snap Token
            fetch('/payment', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                // Buka popup Snap.js di halaman yang sama
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log('Payment Success:', result);
                        alert('Payment successful! Check your email for confirmation.');
                    },
                    onPending: function(result) {
                        console.log('Payment Pending:', result);
                        alert('Payment is pending. Please complete your payment.');
                    },
                    onError: function(result) {
                        console.error('Payment Error:', result);
                        alert('Payment failed. Please try again.');
                    },
                    onClose: function() {
                        console.log('Payment popup closed without finishing the transaction.');
                    }
                });
            })
            .catch(error => console.error('Error:', error));
        };
    </script>
</body>
</html>
