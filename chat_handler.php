<?php
$file = 'messages.json';
$action = $_GET['action'] ?? '';

if ($action === 'send') {
    $user = htmlspecialchars($_POST['username'] ?? 'User');
    $msg = htmlspecialchars($_POST['message'] ?? '');

    if (!empty($msg)) {
        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        $data[] = ['user' => $user, 'text' => $msg, 'time' => date('H:i')];
        if (count($data) > 20) array_shift($data); // Keep it light
        file_put_contents($file, json_encode($data));
    }
    exit;
}


if ($action === 'fetch') {
    $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    if (empty($data)) {
        echo "<div style='color:gray;text-align:center'>No messages yet.</div>";
    } else {
        foreach ($data as $m) {
            echo "<div style='background:rgba(255,255,255,0.1);padding:10px;margin-bottom:8px;border-radius:10px;'>
                    <small style='opacity:0.5'>{$m['time']}</small> <b>{$m['user']}:</b> {$m['text']}
                  </div>";
        }
    }
    exit;
}


if ($action === 'clear') {
    file_put_contents($file, json_encode([]));
    exit;
}
?>