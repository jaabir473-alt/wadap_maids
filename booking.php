<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Service | Wadap Maids</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="booking-wrapper">
    <header class="form-header">
        <h1>Wadap Maids Booking</h1>
        <p>Premium Cleaning Services for Penang & Kedah</p>
    </header>

    <main class="form-container">
        <form action="submit_booking.php" method="POST">
            
            <section class="form-section">
                <h3>1. Personal Details</h3>
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Ahmad Ali" required>
                </div>
                <div class="input-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="012-XXXXXXX" required>
                </div>
            </section>

            <section class="form-section">
                <h3>2. Service Information</h3>
                <div class="input-group">
                    <label for="service_id">Service Type</label>
                    <select name="service_id" id="service_id" required>
                        <option value="">-- Choose a Service --</option>
                        <option value="1">Basic Cleaning (RM25/hr)</option>
                        <option value="2">Deep Cleaning (RM50/hr)</option>
                        <option value="3">Office Pro (RM40/hr)</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="booking_date">Preferred Date</label>
                    <input type="date" id="booking_date" name="booking_date" required>
                </div>
            </section>

            <section class="form-section">
                <h3>3. Location Details</h3>
                <div class="input-group">
                    <label for="address">Full Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Street, Taman, Postcode" required></textarea>
                </div>
            </section>

            <button type="submit" name="submit" class="btn-gold">Confirm Booking Request</button>
        </form>
    </main>
</div>

</body>
</html>