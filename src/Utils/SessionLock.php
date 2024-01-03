<?php

namespace Axio\Session\Utils;

use Axio\Session\Interfaces\SessionLockInterface;

/**
 * Class SessionLock
 * Provides session locking mechanism to control access to session data.
 *
 * @package Axio\Session\Utils
 */
class SessionLock implements SessionLockInterface
{
    /** @var resource|null The file pointer resource for locking. */
    private $lockFile = null;

    private static ?SessionLock $instance = null;

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

    public function acquireLock(string $sessionId): bool
    {
        $lockFilePath = session_save_path() . '/sess_' . $sessionId;
        $lockFile = @fopen($lockFilePath, 'r+');

        if ($lockFile === false) {
            throw new \RuntimeException("Failed to open or create session file at: $lockFilePath");
        }

        if (!flock($lockFile, LOCK_EX | LOCK_NB)) {
            fclose($lockFile);
            throw new \RuntimeException("Failed to acquire lock on session file: $lockFilePath");
        }

        $this->lockFile = $lockFile;
        return true;
    }

    public function releaseLock(): bool
    {
        if ($this->lockFile !== null) {
            flock($this->lockFile, LOCK_UN);
            fclose($this->lockFile);
            $this->lockFile = null;
            return true;
        }

        return false;
    }
}
