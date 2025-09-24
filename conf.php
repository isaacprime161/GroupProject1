<?php
$conf = [
    'site_title' => 'Dadaeb.co – Buy & Sell Cars',
    'site_email' => 'info@dadaeb.co',
    'site_url'   => 'http://localhost:8000',
    'language'   => 'en',

    // DB settings
    'db_host' => 'localhost',
    'db_port' => '5434',
    'db_name' => 'bbit_dedsec',
    'db_user' => 'postgres',
    'db_pass' => '1a2bacac',

    // Mail settings
    'mail_type'   => 'smtp',
    'smtp_host'   => 'smtp.gmail.com',
    'smtp_user'   => 'bethueldadaeb@gmail.com',
    'smtp_pass'   => 'nibu wovt mqca uuzo', 
    'smtp_port'   => 465,
    'smtp_secure' => 'ssl'
];

// =====================
// Database connection
// =====================
try {
    $conn = new PDO(
        "pgsql:host={$conf['db_host']};port={$conf['db_port']};dbname={$conf['db_name']}",
        $conf['db_user'],
        $conf['db_pass']
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
