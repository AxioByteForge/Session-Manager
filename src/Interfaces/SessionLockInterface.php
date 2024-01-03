<?php

namespace Axio\Session\Interfaces;

/**
 * Interface SessionLockInterface
 * Defines methods for session locking mechanism.
 *
 * @package Axio\Session\Interfaces
 */
interface SessionLockInterface
{
    /**
     * Acquires a lock on the session to control access.
     *
     * @param string $sessionId The session ID to lock.
     *
     * @return bool True if the lock was successfully acquired, false otherwise.
     */
    public function acquireLock(string $sessionId): bool;

    /**
     * Releases the lock on the session.
     *
     * @return bool True if the lock was successfully released, false otherwise.
     */
    public function releaseLock(): bool;
}
