<?php

namespace Axio\Session\Interfaces;

/**
 * Interface SessionInterface
 * @package MyApp\Session
 */
interface SessionInterface
{
    public function start(): void;

    public function set(string $key, $value): void;

    public function get(string $key, $default = null);

    public function delete(string $key): void;

    public function destroy(): void;

    public function regenerate(): void;
}
