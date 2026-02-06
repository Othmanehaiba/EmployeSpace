<?php
try {
    // Load .env manually since we bypass Laravel
    $env = parse_ini_file('.env');
    
    $dsn = "pgsql:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$env['DB_DATABASE']}";
    $user = $env['DB_USERNAME'];
    $password = $env['DB_PASSWORD'];

    echo "Connecting to $dsn with user $user...\n";

    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    echo "Connected successfully!\n";
    
    // Check if tables exist
    $stmt = $pdo->query("SELECT to_regclass('public.candidate_cvs')");
    $result = $stmt->fetchColumn();
    echo "candidate_cvs table: " . ($result ? "EXISTS" : "MISSING") . "\n";
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
