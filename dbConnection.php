<?php
require 'vendor/autoload.php';
use Illuminate\Hashing\BcryptHasher;

class Dbconnection {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    private function connect() {
        try {
            // Create a PDO instance and set the error mode
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getUsersByLimit($start, $end) {
        try {
            // Calculate the number of records to skip (OFFSET)
            $limit = $end - $start + 1;
            $query = 'SELECT email, password FROM users LIMIT :limit OFFSET :offset';
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $start, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    public function fetchUser($email) {
        try {
            // Correct query to fetch a single user by email
            $query = 'SELECT email, password FROM users WHERE email = :email';
            
            // Prepare the query
            $stmt = $this->pdo->prepare($query);
            
            // Bind the email parameter
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            
            // Execute the query
            $stmt->execute();
            echo 'user fetchhed';
            // Fetch and return the result as an array of objects (in this case, only one user)
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    public function fetchUsers() {
        try {
            $query = 'SELECT email, password,name,date_of_birth FROM users'; // Adjust the query if necessary
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            
            // Fetch all results as objects
            return $stmt->fetchAll(PDO::FETCH_OBJ); // This should return an array of objects
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    
    // public function compare($start, $end, $inputPassword) {
    //     // Fetch users' email and password for the given range
    //     $users = $this->getUsersByLimit($start, $end);
    
    //     // Initialize the BcryptHasher
    //     $hasher = new BcryptHasher();
    
    //     // Array to hold the result
    //     $matchedUsers = [];
    
    //     // Loop through each user and compare passwords directly
    //     foreach ($users as $user) {
    //         // Report which user's password is being compared
    //         echo "Comparing password for user: {$user->email}\n";
    
    //         // Compare the input password with the stored bcrypt hashed password
    //         if ($hasher->check($inputPassword, $user->password)) {
    //             // If password matches, store the user's email
    //             echo "Password match found for: {$user->email}\n";
    //             $matchedUsers[] = $user->email;
    //         } else {
    //             // Report if password does not match
    //             echo "Password for {$user->email} is incorrect.\n";
    //         }
    //     }
    
    //     // Return the result as a JSON response
    //     return json_encode($matchedUsers);
    // }
    
    // public function SingleComparison($email, $inputPassword) {
    //     try {
    //         // Fetch the user by email
    //         $user = $this->fetchUser($email);
    //         print_r($user);
    //         // Check if the user was found
    //         if ($user) {
    //             // Initialize the BcryptHasher (using Laravel's Hash package)
    //             $hasher = new BcryptHasher();
    
    //             // Compare the input password with the stored password (hashed)
    //             if ($hasher->check($inputPassword, $user->password)) {
               
    //                 echo "Password matched for: {$user->email}\n";
    //                 return $user->email; // Return the email if passwords match
    //             } else {
                   
    //                 echo "Password for {$user->email} is incorrect.\n";
    //                 return false; 
    //             }
    //         } else {
                
    //             echo "User with email {$email} not found.\n";
    //             return false; 
    //         }
    //     } catch (PDOException $e) {
    //         die("Query failed: " . $e->getMessage());
    //     }
    // }
    // public function MultiComparison($inputPassword) {
    //     try {
        
    //         $users = $this->fetchUsers(); 
           
    //         $hasher = new BcryptHasher();
    

    //         foreach ($users as $user) {
    //             echo "Checking password for user: {$user->email}\n";  
    
             
    //             if ($hasher->check($inputPassword, $user->password)) {
                  
    //                 echo "Password matched for user: {$user->email}\n";  
    //                 echo "Email: {$user->email}, Password: {$user->password}\n"; 
    //                 break; 
    //             } else {
                  
    //                 echo "Password for {$user->email} is incorrect.\n"; 
    //             }
    //         }
    
    //     } catch (PDOException $e) {
    //         die("Query failed: " . $e->getMessage());
    //     }
    // }
    
    
    
    
}
?>
