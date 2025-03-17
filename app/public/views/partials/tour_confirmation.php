<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="../../assets/css/history.css">
</head>
<body>
    <div class="booking-wrapper">
        <div class="booking-nav">
            <a href="/Reservation" class="booking-back">
                <img src="../../assets/img/history/back-arrow.png" alt="Back">
            </a>
            <div class="booking-logo">
                <img src="../../assets/img/history/logo1.png" alt="Haarlem Festival">
            </div>
        </div>

        <div class="booking-box">
            <div class="booking-box-header">
                <div class="booking-title">
                    <span class="date-time-dot"></span>
                    <span>Booking Confirmation</span>
                </div>
            </div>

            <div class="booking-box-content">
                <div class="booking-confirmation-details">
                    <div class="guide-info">
                    <img src="/assets/img/history/<?= htmlspecialchars($details['GuideImage']) ?>"
                        alt="<?= htmlspecialchars($details['GuideName']) ?>"
                        class="guide-image">
                        <h4>Your Tour Guide</h4>
                        <p><?= htmlspecialchars($details['GuideName'] ?? 'No Guide Assigned') ?></p>
                    </div>
                    
                    <div class="tour-details">
                        <h4>Tour Details</h4>
                        <p><strong>Date:</strong> <?= !empty($details['TourDate']) ? date('l, F j, Y', strtotime($details['TourDate'])) : 'N/A' ?></p>
                        <p><strong>Time:</strong> <?= !empty($details['TourTime']) ? date('h:i A', strtotime($details['TourTime'])) : 'N/A' ?></p>
                        <p><strong>Language:</strong> <?= htmlspecialchars($details['Language'] ?? 'N/A') ?></p>
                        <p><strong>Ticket Type:</strong> <?= htmlspecialchars($details['TicketType'] ?? 'N/A') ?></p>
                        <p><strong>Number of Seats:</strong> <?= htmlspecialchars($details['Seats'] ?? 'N/A') ?></p>
                        <p><strong>Total Price:</strong> €<?= !empty($details['TotalPrice']) ? number_format($details['TotalPrice'], 2) : '0.00' ?></p>
                    </div>
                </div>

                <div class="booking-actions">
                    <a href="/Reservation" class="booking-submit">Make Another Booking</a>
                    <a href="/history" class="booking-submit">Back to History</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
