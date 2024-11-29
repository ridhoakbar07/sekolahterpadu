<?php
return [
    "title" => "Log Aktivitas",
    "group" => "Monitoring",
    "single" => "Aktivitas",
    "columns" => [
        "model" => "Model",
        "response_time" => "Waktu Respons",
        "status" => "Status",
        "method" => "Metode",
        "url" => "URL",
        "referer" => "Referer",
        "query" => "Query",
        "remote_address" => "Alamat Jarak Jauh",
        "user_agent" => "User Agent",
        "response" => "Respons",
        "level" => "Level",
        "user" => "Pengguna",
        "log" => "Log",
        "created_at" => "Dibuat Pada",
        "updated_at" => "Diperbarui Pada"
    ],
    "actions" => [
        "clear" => [
            "label" => "Hapus Aktivitas",
            "success" => [
                "title" => "Aktivitas Dihapus",
                "body" => "Semua aktivitas telah dihapus."
            ],
        ],
        "poll" => [
            "label" => "Polling Waktu Nyata",
            "enabled" => [
                "title" => "Polling Diaktifkan",
                "body" => "Aktivitas akan dipolling setiap 2 detik."
            ],
            "disabled" => [
                "title" => "Polling Dinonaktifkan",
                "body" => "Aktivitas tidak akan dipolling lagi."
            ]
        ]
    ]
];
