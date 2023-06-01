# Secure Account Manager

Secure Account Manager is a web application built with PHP and Bootstrap that allows users to securely manage their accounts for various platforms. It provides features such as adding accounts, editing account details, and encrypting the account data using a master key.

## Features

- **Account Management**: Users can add accounts for different platforms, including the platform name, username, and password.
- **Multiple Accounts**: Users can add multiple accounts for the same platform.
- **Editing Account Details**: Users can edit the details of existing accounts, including the username and password.
- **Data Encryption**: All account data is encrypted using a master key provided by the user. This ensures that the data is securely stored.
- **Security Measures**: The application uses AES-256-CBC encryption algorithm to encrypt the account data, ensuring a high level of security.

## Installation

1. Clone the repository to your local machine.
2. Make sure you have PHP installed on your system.
3. Start a local server or configure your web server to serve the application files.
4. Access the application in your web browser.

## Usage

1. Launch the application in your web browser.
2. On the home page, enter the master key to access the account management features.
3. Use the navigation menu to add new accounts, edit existing accounts, or view the account list.
4. When adding or editing an account, enter the required details and click "Save" to store the account securely.
5. The account data will be encrypted using the master key, ensuring that it remains secure even in the event of unauthorized access.

## Security Considerations

- It is important to keep the master key secure and not share it with unauthorized individuals.
- Regularly backup the database to prevent data loss.
- Follow secure coding practices to protect against common web vulnerabilities.
- Keep the application and server software up to date to address any security vulnerabilities.

## License

This project is licensed under the [MIT License](LICENSE).

## Contributing

Contributions are welcome! If you have any suggestions, bug fixes, or improvements, please submit a pull request.

## Acknowledgements

This project uses the following open-source libraries:

- Bootstrap: https://getbootstrap.com/
- PHP: https://www.php.net/
- OpenSSL: https://www.openssl.org/

## Contact

For any inquiries or issues, please contact [irfanfateh0@gmail.com](mailto:irfanfateh0@gmail.com).
