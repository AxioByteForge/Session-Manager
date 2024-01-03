<?php

namespace Axio\Session\Handlers;

use Axio\Session\Utils\FlashMessage;
use Axio\Session\Traits\SessionTrait;
use Axio\Session\Interfaces\SessionInterface;

/**
 * Class SessionHandler
 * @package Axio\Session\Handlers
 */
class SessionHandler implements SessionInterface
{
    use SessionTrait;

    private static ?SessionHandler $instance = null;

    // Change the constructor visibility to private
    public function __construct()
    {
        $this->start();
    }

    // Provide a method to retrieve the instance
    public static function getInstance(): SessionHandler
    {
        if (self::$instance === null) {
            self::$instance = new self(); // This will call the private constructor
        }

        return self::$instance;
    }

    // Add a static method to set an instance (if needed)
    public static function setInstance(SessionHandler $instance): void
    {
        self::$instance = $instance;
    }

    public function start(): void
    {
        if (!session_id()) {
            session_start();
        }
    }

    public function set(string $key, $value): void
    {
        $sessionData = $_SESSION;
        $keys = explode('.', $key);
        $temp = &$sessionData;

        foreach ($keys as $nestedKey) {
            if (!isset($temp[$nestedKey]) || !is_array($temp[$nestedKey])) {
                $temp[$nestedKey] = [];
            }
            $temp = &$temp[$nestedKey];
        }

        $temp = $value;

        $_SESSION = $sessionData;
    }

    public function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $value = $_SESSION;

        foreach ($keys as $nestedKey) {
            if (is_array($value) && array_key_exists($nestedKey, $value)) {
                $value = $value[$nestedKey];
            } else {
                return $default;
            }
        }

        return $value;
    }

    public function delete(string $key): void
    {
        if ($this->validateKey($key) && isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy(): void
    {
        session_unset();
        session_destroy();
    }

    public function regenerate(): void
    {
        $this->destroy();
        session_regenerate_id();
    }

    public function generateCsrfToken(string $tokenName = 'csrf_token'): string
    {
        $token = bin2hex(random_bytes(32));
        $this->set($tokenName, $token);
        
        return $token;
    }

    public function validateCsrfToken(string $submittedToken, string $tokenName = 'csrf_token'): bool
    {
        $storedToken = $this->get($tokenName);

        if ($storedToken && hash_equals($storedToken, $submittedToken)) {
            $this->delete($tokenName);
            return true;
        }

        return false;
    }

    public static function displayAll(): void
    {
        $sessionData = $_SESSION;

        if (!empty($sessionData) && is_array($sessionData)) {
            echo "<pre>";
            print_r($sessionData);
            echo "</pre>";
        } else {
            echo "No session data available.";
        }
    }
}
