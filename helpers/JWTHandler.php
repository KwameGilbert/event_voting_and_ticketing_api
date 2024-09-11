<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler
{
    // Secret key for encoding/decoding JWT
    private $secret_key;
    private $algorithm;

    public function __construct()
    {
        // Define your secret key (should be stored securely)
        $this->secret_key = $_ENV['JWT_SECRET_KEY'];
        $this->algorithm = $_ENV['JWT_ALGORITHM'];
    }

    // Function to generate a JWT
    public function generateToken($user_data)
    {
        // Define the header (using HS256 for signing)
        $header = json_encode([
            "alg" => $this->algorithm,
            "typ" => "JWT"
        ]);

        // Define the payload (claims)
        $payload = [
                'issuer' => 'firstcode.com',             // Issuer
                'issued_at' => time(),                   // Issued at time
                'expiration' => time() + (60 * 60),      // Expiration time (1 hour)
                'data' => $user_data                     // User data (id, email, role, etc.)
            ];

        // Encode the header and payload to Base64URL format
        $base64Header = $this->base64URLEncode($header);
        $base64Payload = $this->base64URLEncode(json_encode($payload));

        // Create the signature using HMAC SHA256
        $signature = hash_hmac('sha256', "$base64Header.$base64Payload", $this->secret_key, true);

        // Base64URL encode the signature
        $base64Signature = $this->base64URLEncode($signature);

        // Concatenate the header, payload, and signature to create the JWT
        return "$base64Header.$base64Payload.$base64Signature";
    }

    private function base64URLEncode($data)
    {
        // Base64 encode the data and make it URL safe
        return str_replace(['+', '/', '='], ['-', '_',
            ''
        ], base64_encode($data));
    }

    // Function to decode and verify a JWT
    public function verifyToken($jwt)
    {
        try {
            // Decode the JWT
            $decoded = JWT::decode($jwt, new Key($this->secret_key, $this->algorithm ));

            // Return the decoded data if verification is successful
            return (array) $decoded->data;
        } catch (Exception $e) {
            // If verification fails, return false or handle the error
            return false;
        }
    }
}
