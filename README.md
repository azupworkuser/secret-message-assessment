# Secret message assessment

This is an EndToEnd Encrypted Messaging System, where the messages being transmitted are encrypted on the sender's device and can only be decrypted by the intended recipient's device. The EndToEnd Encryption mechanism uses a set of public and private identifier keys for each user, as well as a unique symetric key for each message. It does not allow the backend server to decrypt the messages itself.

I am using the Hybrid encryption pattern here, in which, a unique symetric key is used to encrypt/decrypt the orignal message, while the users public and private identifier keys are used to encrypt/decrypt the symetric key.

**Technical Specification:**

-   Framework: Laravel 10
-   Database: Mysql 8
-   Environment: Docker

**How to install:**

-   Install make tool and run the below command.
-   `make init`

**Scope & Technical Summary:**

1. It’s open messaging system, which works on the invitation basis. No need to signup or login. Simply invite the colleague and start sending and receiving messages.
2. I have used Js-Encrypt and CryptoJS library of Javascript, which provides a set of public and private identifier keys for each user. It provide features to encrypt/decrypt the messages and Symentric key.
3. Encryption at Sender side: For each message, a unique encryption key is generated to encrypt the text message. The encryption key is further encrypted using the public identifier key of the recipient.
4. Decryption at Recipient side: For each message, the encryption key is first descrypted using the Recipient private identifier key and then the decrypted key is used to decrypt the original text message.
5. Storing Confidentail Details: Public key is stored in the database as the public identifier. As well as, the symentric key is also encrypted using public key of sender and receiver and stored in the database. This confidential information is not exposed in the API call.

**How to run the project:**

1. Open this Url http://localhost:8080 in a browser window.
2. To start messaging, add your details and Submit the form. It will provide you an invitatation link, which can be used by the recipient to join the messaging room.
3. Open another browser and join the messaging room as a recipient using the invitation link.
4. Now both the ends are ready to send and recieve the secured messages. Let’s start sending and receiving messages.

**Phpmyadmin Url:**

-   http://localhost:8082

Due to time limitation, It was difficult to include more features like Login, Signup, PrivateKeySharing between multiple devices to enable communication from more than one device, etc.

Kindly let me know if anything is not clear. I can do the screensharing and can explain each part of the application.

Thanks
