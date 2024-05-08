<?php 
    require __DIR__ . '/../vendor/autoload.php'; 
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__.'/../');
    $dotenv->load();

    $server = $_ENV['DB_HOST'] ?? '';
    $user = $_ENV['DB_USER'] ?? '';
    $password = $_ENV['DB_PASSWORD'] ?? '';
    $db = $_ENV['DB_NAME'] ?? '';

    
    if ($server && $user && $db) {
        $conn = new mysqli($server, $user, $password, $db);

        if ($conn->connect_error) {
            echo "
                <script>
                    window.location.href = '../errors/errors.php?errorID=1025';
                </script>
            ";
            die();
        }
        if (file_exists('.env')) {
            unlink('.env');
        }
    } else {
        
       echo "
            <script>
                window.location.href = '../errors/errors.php?errorID=1025';
            </script>
        ";
    }


?>