<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IMAP Email Fetcher</title>

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f4f4f4;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      width: 100%;
      background-color: #f4f4f4;
      flex-direction: column;
    }

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 300px;
    }

    label {
      display: block;
      margin-bottom: 10px;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: #4caf50;
      color: white;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .email-card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      margin-top: 20px;
    }

    .email-card {
      display: flex;
      flex-direction: column;
      background-color: #fff;
      padding: 20px;
      margin: 10px;
      width: calc(33.33% - 20px);
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: left;
    }

    .email-data {
      margin-top: 10px;
    }

    .email-card-container:after {
      content: "";
      flex-grow: 99999;
    }
  </style>
</head>

<body>
  <div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="email">Sender Email:</label>
      <input type="email" name="email" required>

      <label for="date">Date Filter (YYYY-MM-DD):</label>
      <input type="date" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'); ?>" required>

      <input type="submit" value="Fetch Emails">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Retrieve form data
      $userEmail = $_POST["email"];
      $dateFilter = $_POST["date"];

      // Gmail IMAP settings
      $server = '{imap.gmail.com:993/imap/ssl}INBOX';
      $username = 'youraccount@gmail.com';  // Replace with your Gmail email
      $password = 'appkey without space';  // Replace with your App password(Genrated from gmail)

      // Connect to the IMAP server
      $mailbox = imap_open($server, $username, $password);
      echo '<div class="email-card-container">';

      if (!$mailbox) {
        echo '<div class="email-card">Unable to connect. Error: ' . imap_last_error() . '</div>';
      } else {
        // Search for all emails from the specified sender in the INBOX
        $mailIds = imap_search($mailbox, 'FROM "' . $userEmail . '" SINCE "' . date('d-M-Y', strtotime($dateFilter)) . '"');

        if ($mailIds) {
          // Iterate through each email
          foreach ($mailIds as $mailId) {
            // Get the header information for the email
            $header = imap_headerinfo($mailbox, $mailId);

            // Display the subject and other details of the email in a card
            echo '<div class="email-card">';
            echo '<strong>Subject:</strong> ' . htmlspecialchars($header->subject) . "<br>";
            echo '<strong>From:</strong> ' . htmlspecialchars($header->fromaddress) . "<br>";
            echo '<strong>Date:</strong> ' . htmlspecialchars($header->date) . "<br>";

            // Additional email data can be shown below the card
            echo '<div class="email-data">';

            // Example: Displaying the HTML message body
            $structure = imap_fetchstructure($mailbox, $mailId);
            $messageBody = imap_fetchbody($mailbox, $mailId, 1, FT_PEEK); // Adjust the part number based on your email structure

            // Check if the content type is HTML
            $contentType = $structure->subtype;

            if ($contentType == 'HTML') {
              // Display the HTML message body
              echo '<strong>Message Body:</strong> ' . $messageBody . "<br>";
            } else {
              // If it's not HTML, display plain text
              echo '<strong>Message Body:</strong> ' . nl2br(htmlspecialchars(quoted_printable_decode($messageBody))) . "<br>";
            }

            // Add a "Read More" link
            echo '<a href="#">Read More</a>';

            // Add any additional data or processing here

            echo '</div>';

            echo '</div>';
          }
        } else {
          echo '<div class="email-card">No emails found from ' . htmlspecialchars($userEmail) . ' in the INBOX since ' . htmlspecialchars($dateFilter) . '.</div>';
        }

        // Close the connection to the IMAP server
        imap_close($mailbox);
      }

      echo '</div>'; 
    }
    ?>

  </div>
</body>

</html>