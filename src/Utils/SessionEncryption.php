<?php

namespace Axio\Session\Utils;

use Axio\Session\Exceptions\MissingEncryptionKeyException;

class SessionEncryption
{
    private static ?SessionEncryption $instance = null;

    private static string $method = 'AES-256-CBC';
    private static string $secretKey = '';
    private static int $ivLength = 16;
    private static string $hash = "sha256";

    private function __construct()
    {
    }

   // Provide a method to retrieve the instance
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self(); // This will call the private constructor
        }

        return self::$instance;
    }

    public static function setMethod(string $method): void
    {
        self::$method = $method;
    }

    public static function setSecretKey(string $secretKey): void
    {
        self::$secretKey = $secretKey;
    }

    public static function setIvLength(int $ivLength): void
    {
        self::$ivLength = $ivLength;
    }

    public static function setHash(string $hash): void
    {
        self::$hash = $hash;
    }

    public static function generateRandomKey(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    public static function changeEncryptionMethod(string $newMethod): void
    {
        self::$method = $newMethod;
    }

    public static function changeIvLength(int $newIvLength): void
    {
        self::$ivLength = $newIvLength;
    }

    public static function encrypt(string $data): string
    {
        if (empty(self::$secretKey)) {
            throw new MissingEncryptionKeyException('Secret key is not set.');
        }
        $key = hash(self::$hash, self::$secretKey);
        $iv = openssl_random_pseudo_bytes(self::$ivLength);
        $encrypted = openssl_encrypt($data, self::$method, $key, 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    public static function decrypt(string $data): ?string
    {
        if (empty(self::$secretKey)) {
            throw new MissingEncryptionKeyException('Secret key is not set.');
        }

        $key = hash(self::$hash, self::$secretKey);
        $data = base64_decode($data);
        $iv = substr($data, 0, self::$ivLength);
        $encrypted = substr($data, self::$ivLength);
        $decrypted = openssl_decrypt($encrypted, self::$method, $key, 0, $iv);

        return ($decrypted !== false) ? $decrypted : null;
    }
}
