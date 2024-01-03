<?php

namespace Axio\Session\Handlers;

use Axio\Session\Handlers\SessionHandler;

/**
 * Class NamespaceSessionHandler
 * Extends the SessionHandler class to provide namespace support for session data.
 *
 * @package Axio\Session\Handlers
 */
class NamespaceSessionHandler extends SessionHandler
{
    private static ?NamespaceSessionHandler $instance = null;

    protected string $namespace;

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
    
    /**
     * Set the namespace for session data.
     *
     * @param string $namespace The namespace for session data.
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    /**
     * Get the namespaced key for session data.
     *
     * @param string $key The key for session data.
     * @return string The namespaced key for session data.
     */
    protected function getNamespacedKey(string $key): string
    {
        return $this->namespace . '_' . $key;
    }

    /**
     * Set a session value within the namespace.
     *
     * @param string $key The key for session data.
     * @param mixed $value The value to be stored in the session.
     */
    public function set(string $key, $value): void
    {
        parent::set($this->getNamespacedKey($key), $value);
    }

    /**
     * Get a session value from the namespace.
     *
     * @param string $key The key for session data.
     * @param mixed|null $default Optional. Default value if the key doesn't exist.
     * @return mixed|null The value associated with the given key, or null if not found.
     */
    public function get(string $key, $default = null)
    {
        return parent::get($this->getNamespacedKey($key), $default);
    }

    /**
     * Delete a session value from the namespace.
     *
     * @param string $key The key for session data to be deleted.
     */
    public function delete(string $key): void
    {
        parent::delete($this->getNamespacedKey($key));
    }
}
