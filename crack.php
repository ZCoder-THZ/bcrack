<?php 
   require 'vendor/autoload.php';
   use Illuminate\Hashing\BcryptHasher;

    class PasswordTester {
        private $db;
        public function __construct($db) {
            $this->db=$db;
          
        }
        private function compare($password,$user){
            $bcrypt=new BcryptHasher();
            if ($bcrypt->check($password, $user->password)) {
                echo "Password matched for: {$user->email}\n";
                return $user->email; // Return the email if passwords match
            } else {
                echo "Password for {$user->email} is incorrect.\n";
                return false;
            }
        }
        public function singleComparison($email, $password) {
            $user = $this->db->fetchUser($email);
            
            if ($user) {
           
                try {
                     $this->compare($password,$user);
                } catch (\Throwable $th) {
                    die("An error occurred: " . $th->getMessage());
                }
            } else {
                die("User not found.");
            }
        }
        
        public function multipleComparison($password) {
           try {
            $users=$this->db->fetchUsers();
            foreach ($users as $user) {
                        $this->compare($password,$user);
                        }
           } catch (\Throwable $th) {
                       die("Query failed: ");

           }
                
        }
    }
?>
