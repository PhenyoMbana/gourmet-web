<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function add_notification($message, $type = 'success') {
    if (!isset($_SESSION['notifications'])) {
        $_SESSION['notifications'] = [];
    }
    
    $_SESSION['notifications'][] = [
        'message' => $message,
        'type' => $type,
        'timestamp' => time()
    ];
}

function get_notifications() {
    $notifications = isset($_SESSION['notifications']) ? $_SESSION['notifications'] : [];
    $_SESSION['notifications'] = []; // Clear notifications after retrieving
    return $notifications;
}

function display_notifications() {
    $notifications = get_notifications();
    $output = '';
    
    foreach ($notifications as $notification) {
        $output .= sprintf(
            '<div class="notification %s" data-timestamp="%s">%s</div>',
            $notification['type'],
            $notification['timestamp'],
            htmlspecialchars($notification['message'])
        );
    }
    
    return $output;
}
?> 