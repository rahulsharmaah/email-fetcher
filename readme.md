# PHP IMAP Email Fetcher

This repository contains PHP code snippets for connecting to an email account using PHP's IMAP extension, fetching emails based on criteria, and displaying their details. The code is designed to work with Gmail, and the README provides instructions on how to set up IMAP access for Gmail accounts.

## Prerequisites

Before using the code, ensure you have the following:

- A web server with PHP support
- IMAP extension enabled in your PHP configuration
- Gmail account

## Setting Up Gmail for IMAP Access

1. Log in to your Gmail account.
2. Click on the gear icon in the top-right corner and select "See all settings."
3. Go to the "Forwarding and POP/IMAP" tab.
4. In the "IMAP Access" section, select "Enable IMAP."
5. Save the changes.

## Generating App Password

For security reasons, it's recommended to use an app password when accessing your Gmail account via non-Google apps like PHPMailer.

1. Go to your [Google Account Security](https://myaccount.google.com/security-checkup).
2. Under "Signing in to Google," click on "App passwords."
3. For More Detials checkout Article on Medium [Link](https://medium.com/@rahulsharmaah/fetching-and-displaying-emails-using-php-imap-ef41053c5e43)

## Usage

1. Clone this repository to your local machine.
2. Update the PHP code with your Gmail email and the app password generated.
3. Run the PHP scripts.

Feel free to explore additional IMAP functions and customize the code to fit your specific use case. Happy coding!
