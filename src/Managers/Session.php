<?php

namespace Axio\Session\Managers;

use Axio\Session\Exceptions\SessionException;
use Axio\Session\Handlers\NamespaceSessionHandler;
use Axio\Session\Utils\SessionLock;
use Axio\Session\Handlers\SessionHandler;
use Axio\Session\Utils\SessionEncryption;
use Axio\Session\Utils\SessionExpiration;

/**
 * Class Session
 * @package Axio\Session\Managers
 */
class Session
{
    /**
     * @var SessionHandler|null The session handler instance.
     */
    private static ?SessionHandler $sessionHandler = null;

    /**
     * @var mixed|null Session encryption method or configuration.
     */
    private static ?SessionEncryption $sessionEncryption = null;

    /**
     * @var mixed|null Session expiration time.
     */
    private static ?SessionExpiration $sessionExpiration = null;

    /**
     * @var mixed|null Session lock status.
     */
    private static ?SessionLock $sessionLock = null;

    /**
     * @var mixed|null Session lock status.
     */
    private static ?NamespaceSessionHandler $namespaceSession = null;

    /**
     * Starts the session.
     *
     * @return void
     */
    public static function start(): void
    {
        if (!isset(self::$sessionHandler)) {
            self::$sessionHandler = SessionHandler::getInstance();
        }
        self::$sessionHandler->start();

        self::$sessionEncryption = SessionEncryption::getInstance();
        self::$sessionExpiration = SessionExpiration::getInstance();
        self::$sessionLock == SessionLock::getInstance();
        self::$namespaceSession == NamespaceSessionHandler::getInstance();
    }

    /**
     * Sets a session variable.
     *
     * @param string $key The key for the session variable.
     * @param mixed $value The value to be stored in the session.
     *
     * @return void
     */
    public static function set(string $key, $value): void
    {
        self::$sessionHandler->set($key, $value);
    }

    /**
     * Retrieves a session variable by its key.
     *
     * @param string $key The key for the session variable.
     * @param mixed $default (Optional) Default value if the key is not found.
     *
     * @return string The retrieved session variable value.
     */
    public static function get(string $key, $default = null): string
    {
        return self::$sessionHandler->get($key, $default);
    }

    /**
     * Deletes a session variable by its key.
     *
     * @param string $key The key for the session variable to be deleted.
     *
     * @return void
     */
    public static function delete(string $key): void
    {
        self::$sessionHandler->delete($key);
    }

    /**
     * Destroys the session.
     *
     * @return void
     */
    public static function destroy(): void
    {
        self::$sessionHandler->destroy();
    }

    /**
     * Regenerates the session ID.
     *
     * @return void
     */
    public static function regenerate(): void
    {
        self::$sessionHandler->regenerate();
    }

    /**
     * Displays all session variables (for debugging purposes).
     *
     * @return void
     */
    public static function displayAll(): void
    {
        self::$sessionHandler->displayAll();
    }

    /**
     * Generates a CSRF token.
     *
     * @param string $tokenName (Optional) The name of the CSRF token (defaults to 'csrf_token').
     *
     * @return string The generated CSRF token.
     */
    public static function generateCsrfToken(string $tokenName = 'csrf_token'): string
    {
        return self::$sessionHandler->generateCsrfToken($tokenName);
    }

    /**
     * Validates a CSRF token against a submitted token.
     *
     * @param string $submittedToken The submitted token to be validated.
     * @param string $tokenName (Optional) The name of the CSRF token (defaults to 'csrf_token').
     *
     * @return bool Returns true if the submitted token is valid, false otherwise.
     */
    public static function validateCsrfToken(string $submittedToken, string $tokenName = 'csrf_token'): bool
    {
        return self::$sessionHandler->validateCsrfToken($submittedToken, $tokenName);
    }

    /**
     * Sets the encryption method for the session.
     *
     * @param string $method The encryption method to be set.
     *
     * @return void
     */
    public static function setMethod(string $method): void
    {
        self::$sessionEncryption->setMethod($method);
    }

    /**
     * Sets the secret key for encryption in the session.
     *
     * @param string $secretKey The secret key to be set for encryption.
     *
     * @return void
     */
    public static function setSecretKey(string $secretKey): void
    {
        self::$sessionEncryption->setSecretKey($secretKey);
    }

    /**
     * Sets the initialization vector (IV) length for encryption in the session.
     *
     * @param int $ivLength The length of the initialization vector (IV) to be set.
     *
     * @return void
     */
    public static function setIvLength(int $ivLength): void
    {
        self::$sessionEncryption->setIvLength($ivLength);
    }

    /**
     * Sets the hash algorithm for encryption in the session.
     *
     * @param string $hash The hash algorithm to be set for encryption.
     *
     * @return void
     */
    public static function setHash(string $hash): void
    {
        self::$sessionEncryption->setHash($hash);
    }
    /**
     * Changes the encryption method used in the session.
     *
     * @param string $newMethod The new encryption method to be used.
     *
     * @return void
     */
    public static function changeEncryptionMethod(string $newMethod): void
    {
        self::$sessionEncryption->changeEncryptionMethod($newMethod);
    }

    /**
     * Changes the initialization vector (IV) length used in the session encryption.
     *
     * @param int $newIvLength The new IV length to be used for encryption.
     *
     * @return void
     */
    public static function changeIvLength(int $newIvLength): void
    {
        self::$sessionEncryption->changeIvLength($newIvLength);
    }

    /**
     * Generates a random key for encryption purposes.
     *
     * @param int $length (Optional) The length of the random key (defaults to 32).
     *
     * @return string The generated random key.
     */
    public static function generateRandomKey(int $length = 32): string
    {
        return self::$sessionEncryption->generateRandomKey($length);
    }

    /**
     * Encrypts the provided data using the session's encryption settings.
     *
     * @param string $data The data to be encrypted.
     *
     * @return string The encrypted data.
     */
    public static function encrypt(string $data): string
    {
        return self::$sessionEncryption->encrypt($data);
    }

    /**
     * Decrypts the provided data using the session's encryption settings.
     *
     * @param string $data The data to be decrypted.
     *
     * @return string The decrypted data.
     */
    public static function decrypt(string $data): string
    {
        return self::$sessionEncryption->decrypt($data);
    }

    /**
     * Set the session expiration time in seconds.
     *
     * @param int $expireTime The expiration time for the session in seconds.
     * @return void
     */
    public static function setSessionExpiration(int $expireTime): void
    {
        self::$sessionExpiration->setSessionExpiration($expireTime);
    }

    /**
     * Get the session expiration time in seconds.
     *
     * @return int The session expiration time in seconds.
     */
    public static function getSessionExpiration(): int
    {
        return self::$sessionExpiration->getSessionExpiration();
    }

    /**
     * Checks if the session has expired based on the last activity time and the session expiration time.
     * If expired, destroys the session; otherwise, updates the last activity time.
     *
     * @return void
     */
    public static function checkSessionExpiration(): void
    {
        self::$sessionExpiration->checkSessionExpiration();
    }

    /**
     * Checks if the session has expired based on the last activity time and the session expiration time.
     *
     * @return bool Returns true if the session has expired, false otherwise.
     */
    public static function isSessionExpired(): bool
    {
        return self::$sessionExpiration->isSessionExpired();
    }

    /**
     * Updates the last activity time for the session.
     *
     * @return void
     */
    public static function updateLastActivityTime(): void
    {
        self::$sessionExpiration->updateLastActivityTime();
    }

    /**
     * Acquires a lock for a specific session ID to prevent concurrent access.
     *
     * @param string $sessionId The ID of the session for which the lock is acquired.
     *
     * @return bool Returns true if the lock is successfully acquired, false otherwise.
     */
    public static function acquireLock(string $sessionId): bool
    {
        return self::$sessionLock->acquireLock($sessionId);
    }

    /**
     * Releases the lock acquired for the session.
     *
     * @return bool Returns true if the lock is successfully released, false otherwise.
     */
    public static function releaseLock(): bool
    {
        return self::$sessionLock->releaseLock();
    }


    /**
     * Set the namespace for session data.
     *
     * @param string $namespace The namespace for session data.
     */
    public static function setNamespace(string $namespace): void
    {
        self::$namespaceSession->setNamespace($namespace);
    }

    /**
     * Get the namespaced key for session data.
     *
     * @param string $key The key for session data.
     * @return string The namespaced key for session data.
     */
    protected static function getNamespacedKey(string $key): string
    {
        return self::$namespaceSession->getNamespacedKey($key);
    }

    /**
     * Set a session value within the namespace.
     *
     * @param string $key The key for session data.
     * @param mixed $value The value to be stored in the session.
     */
    public static function setNamespaceValue(string $key, $value): void
    {
        self::$namespaceSession->set($key, $value);
    }

    /**
     * Get a session value from the namespace.
     *
     * @param string $key The key for session data.
     * @param mixed|null $default Optional. Default value if the key doesn't exist.
     * @return mixed|null The value associated with the given key, or null if not found.
     */
    public static function getNamespaceValue(string $key, $default = null)
    {
        return self::$namespaceSession->get($key, $default);
    }

    /**
     * Delete a session value from the namespace.
     *
     * @param string $key The key for session data to be deleted.
     */
    public static function deleteNamespaceValue(string $key): void
    {
        self::$namespaceSession->delete($key);
    }
}
