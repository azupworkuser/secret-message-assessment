import CryptoJS from 'crypto-js';
import JSEncrypt from 'jsencrypt';

const encryptWithAES = (message) => {
    let key = CryptoJS.lib.WordArray.random(16).toString();
    let encrypted = CryptoJS.AES.encrypt(message, key).toString();
    return { 
        message: encrypted,
        key: key 
    };
}

const encryptWithRSA = (symKey, publicKey) => {
    let rsa = new JSEncrypt();
    rsa.setPublicKey(publicKey);
    return rsa.encrypt(symKey);
}

const decryptWithAES = (encryptedMessage, key) => {
    return CryptoJS.AES.decrypt(encryptedMessage, key).toString(CryptoJS.enc.Utf8);
}

const decryptWithRSA = (encryptedSymKey, privateKey) => {
    let rsa = new JSEncrypt();
    rsa.setPrivateKey(privateKey);
    return rsa.decrypt(encryptedSymKey);
}

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