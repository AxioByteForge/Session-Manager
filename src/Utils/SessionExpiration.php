<?php

namespace Axio\Session\Utils;

use Axio\Session\Managers\Session;

/**
 * Class SessionExpiration
 *
 * A utility class to manage session expiration and activity tracking.
 *
 * @package Axio\Session\Utils
 */
class SessionExpiration
{

    private static ?SessionExpiration $instance = null;
    
    /**
     * Session variable storing the last activity timestamp.
     */
    const SESSION_LAST_ACTIVITY = 'last_activity';

    /**
     * Default session expiration time in seconds (30 minutes by default).
     */
    const DEFAULT_SESSION_EXPIRE_TIME = 1800; // 30 minutes in seconds


    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Set the session expiration time in seconds.
     *
     * @param int $expireTime The expiration time for the session in seconds.
     * @return void
     */
    public static function setSessionExpiration(int $expireTime): void
    {
        Session::set('session_expire_time', $expireTime);
    }

    /**
     * Get the session expiration time in seconds.
     *
     * @return int The session expiration time in seconds.
     */
    public static function getSessionExpiration(): int
    {
        return Session::get('session_expire_time', self::DEFAULT_SESSION_EXPIRE_TIME);
    }

    /**
     * Checks if the session has expired based on the last activity time and the session expiration time.
     * If expired, destroys the session; otherwise, updates the last activity time.
     *
     * @return void
     */
    public static function checkSessionExpiration(): void
    {
        if (self::isSessionExpired()) {
            Session::destroy(); // Expire the session if it's past the expiration time
        } else {
            self::updateLastActivityTime(); // Update last activity time if the session is active
        }
    }

    /**
     * Checks if the session has expired based on the last activity time and the session expiration time.
     *
     * @return bool Returns true if the session has expired, false otherwise.
     */
    public static function isSessionExpired(): bool
    {
        $lastActivity = Session::get(self::SESSION_LAST_ACTIVITY);
        $expireTime = self::getSessionExpiration();

        if ($lastActivity !== null && (time() - $lastActivity > $expireTime)) {
            return true;
        }
        return false;
    }

    /**
     * Updates the last activity time for the session.
     *
     * @return void
     */
    public static function updateLastActivityTime(): void
    {
        Session::set(self::SESSION_LAST_ACTIVITY, time());
    }
}
