import CryptoJS from 'crypto-js';
import JSEncrypt from 'jsencrypt';

// Encript the message with a unique sym key.
const encryptWithAES = (message) => {
    let key = CryptoJS.lib.WordArray.random(16).toString();
    let encrypted = CryptoJS.AES.encrypt(message, key).toString();
    return { 
        message: encrypted,
        key: key 
    };
}

// Encript the sym key with public key.
const encryptWithRSA = (symKey, publicKey) => {
    let rsa = new JSEncrypt();
    rsa.setPublicKey(publicKey);
    return rsa.encrypt(symKey);
}

// Decript the message using sym key.
const decryptWithAES = (encryptedMessage, key) => {
    return CryptoJS.AES.decrypt(encryptedMessage, key).toString(CryptoJS.enc.Utf8);
}

// Decript the sym key using private key.
const decryptWithRSA = (encryptedSymKey, privateKey) => {
    let rsa = new JSEncrypt();
    rsa.setPrivateKey(privateKey);
    return rsa.decrypt(encryptedSymKey);
}

// Generate the public and private at the time of registration.
const generateRSAKeyPair = () => {
    let rsa = new JSEncrypt({ default_key_size: 2048 });
    rsa.getKey();
    return { 
        publicKey: rsa.getPublicKey(), 
        privateKey: rsa.getPrivateKey() 
    };
}

export {
    encryptWithAES,
    encryptWithRSA,
    decryptWithAES,
    decryptWithRSA,
    generateRSAKeyPair
};