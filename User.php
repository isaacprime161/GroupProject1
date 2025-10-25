
<?php

require_once _DIR_ . '/../ConnToDB.php';  
require     'C:\Apache24\htdocs\GroupProject1\LabAssignment\Plugins\PHPMailer\vendor\autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;          
use PHPMailer\PHPMailer\Exception;          

// Load .env environment variables
$dotenv = Dotenv\Dotenv::createImmutable(_DIR_ . '/..');
$dotenv->load();

class User {
   private $pdo; 

    public function __construct() {
        global $pdo;
        if (!$pdo) {
            // fallback in case ConnToDB.php wasn't loaded
            $pdo = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        $this->pdo = $pdo;
    }

    // 1. Register a new user
    public function register($name, $email, $password) {
        try {
            // Hash password before saving it
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // SQL query to insert user details into users table
            $stmt = $this->pdo->prepare("
                INSERT INTO users (name, email, password)
                VALUES (:name, :email, :password)");

            // Execute with values
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);

            // Get the newly created user’s ID
            $userId = $this->pdo->lastInsertId();
            
            // Create and send OTP for email verification
            $this->createAndSendOTP($userId, $email);

            return $userId; // Return ID so we can use it for OTP
        } catch (PDOException $e) {
            // If email already exists or something goes wrong
            return false;
        }
    }

    // 2. Create OTP and send email
    public function createAndSendOTP($userId, $email) {
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Set expiry time (10 minutes from now)
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        //echo "<br> createAndSendOTP() is running for user ID: $userId and email: $email<br>";
        // Store OTP in otps table
        $stmt = $this->pdo->prepare("
            INSERT INTO otps (user_id, otp_code, expires_at)
            VALUES (:uid, :otp, :expires)
        ");
        $stmt->execute([
            ':uid' => $userId,
            ':otp' => $otp,
            ':expires' => $expiresAt
        ]);

        //Send OTP to user's email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USER'];
            $mail->Password = $_ENV['MAIL_PASS'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($_ENV['MAIL_USER'], 'TaskApp System');
            $mail->addAddress($email);
            $mail->Subject = 'Your Verification Code';
            $mail->Body = "Your OTP code is: $otp\nIt will expire in 10 minutes.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Optional: For debugging, you can log this instead of echoing
            echo "Email could not be sent. Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    // 3. Verify OTP
    public function verifyOTP($userId, $enteredOtp) {
        // Find valid OTP
        $stmt = $this->pdo->prepare("
            SELECT * FROM otps WHERE user_id = :uid AND otp_code = :otp AND used = 0 AND expires_at > NOW() ORDER BY id DESC LIMIT 1");
        $stmt->execute([':uid' => $userId, ':otp' => $enteredOtp]);
        $otpRecord = $stmt->fetch();

        // If OTP is correct and valid
        if ($otpRecord) {
            // Mark OTP as used
            $this->pdo->prepare("
                UPDATE otps SET used = 1 WHERE id = :id
            ")->execute([':id' => $otpRecord['id']]);

            // Mark user as verified
            $this->pdo->prepare("
                UPDATE users SET is_verified = 1 WHERE id = :uid
            ")->execute([':uid' => $userId]);

            return true;
        } else {
            return false;
        }
    }

    // 4. Login user (check email + password)
    public function login($email, $password) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_verified'] == 1) {
                return $user; // Return user info if verified
            } else {
                return "not_verified"; // They must confirm OTP first
            }
        } else {
            return false; // Invalid password or email
        }
    }

    // 5. Fetch all users (for display table)
    public function getAllUsers() {
        $stmt = $this->pdo->query("
            SELECT id, name, email, is_verified, created_at FROM users ORDER BY name ASC");        
        return $stmt->fetchAll();
    }
}
?>