<?php

function adminNotificationCount(): int
{
    static $count = null;

    if ($count !== null) {
        return $count;
    }

    $file = __DIR__ . '/../../data/contact_messages.json';
    if (!file_exists($file)) {
        $count = 0;
        return $count;
    }

    $messages = json_decode((string) file_get_contents($file), true);
    if (!is_array($messages)) {
        $count = 0;
        return $count;
    }

    $count = count(array_filter($messages, static function ($message): bool {
        return (($message['status'] ?? 'new') === 'new');
    }));

    return $count;
}
