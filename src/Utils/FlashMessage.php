<?php

// namespace Axio\Session\Utils;

// use Axio\Session\Exceptions\SessionException;
// use Axio\Session\Exceptions\FlashMessageException;
// use Axio\Session\Interfaces\SessionInterface;

// /**
//  * Class FlashMessage
//  * @package Axio\Session\Utils
//  */
// class FlashMessage
// {
//     private static string $sessionKey = 'flash_messages';

//     public static function setSessionKey(string $sessionKey): void
//     {
//         self::$sessionKey = $sessionKey;
//     }

//     public static function add(SessionInterface $session, string $message, string $type = 'info'): void
//     {
//         try {
//             $messages = self::getMessages($session);
//             $messages[] = [
//                 'message' => $message,
//                 'type' => $type,
//             ];
//             $session->set(self::$sessionKey, $messages);
//         } catch (SessionException $e) {
//             throw new FlashMessageException('Error adding flash message: ' . $e->getMessage());
//         }
//     }

//     public static function get(SessionInterface $session)
//     {
//         try {
//             $messages = self::getMessages($session);
//             $session->delete(self::$sessionKey);
//             return $messages;
//         } catch (SessionException $e) {
//             throw new FlashMessageException('Error getting flash messages: ' . $e->getMessage());
//         }
//     }

//     private static function getMessages(SessionInterface $session)
//     {
//         try {
//             return $session->get(self::$sessionKey);
//         } catch (SessionException $e) {
//             throw new FlashMessageException('Error retrieving flash messages: ' . $e->getMessage());
//         }
//     }
// }
