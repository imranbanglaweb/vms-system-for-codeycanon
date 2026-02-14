const crypto = require('crypto');

// Generate P-256 (prime256v1) key pair
const ecdh = crypto.createECDH('prime256v1');
ecdh.generateKeys();

const privateKey = ecdh.getPrivateKey();
const publicKey = ecdh.getPublicKey();

// Convert to base64url
function base64urlEncode(buffer) {
    return buffer.toString('base64')
        .replace(/\+/g, '-')
        .replace(/\//g, '_')
        .replace(/=+$/, '');
}

const publicKeyBase64 = base64urlEncode(publicKey);
const privateKeyBase64 = base64urlEncode(privateKey);

console.log('=== VAPID Keys (Node.js generated) ===');
console.log('Public Key:', publicKeyBase64, '(len:', publicKeyBase64.length + ')');
console.log('Private Key:', privateKeyBase64, '(len:', privateKeyBase64.length + ')');
console.log('');
console.log('=== For .env file ===');
console.log('VAPID_PUBLIC_KEY="' + publicKeyBase64 + '"');
console.log('VAPID_PRIVATE_KEY="' + privateKeyBase64 + '"');
