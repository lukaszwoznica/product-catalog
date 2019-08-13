<?php
    require_once("db_config.php");

    class User{
        private $connection;

        public function __construct(){
            $db = new Database();
            $this->connection = $db->dbConnect();
        }

        public function runQuery($sql_query){
            $stmt = $this->connection->prepare($sql_query);
            return $stmt;
        }

        public function logIn($username, $passwd){
            try{
                $stmt = $this->connection->prepare("SELECT user_id, user_name, user_passwd, type_id FROM users WHERE user_name = :username");
                $stmt->execute(array(':username' => $username));
                $user_row = $stmt->fetch(PDO::FETCH_ASSOC);
         
                if($stmt->rowCount() == 1){
                    if(password_verify($passwd, $user_row['user_passwd'])){
                        $_SESSION['user_session'] = $user_row['user_id'];
                        $_SESSION['user_login'] = $user_row['user_name'];
                        $_SESSION['user_type'] = $user_row['type_id'];
                        return true;
                    }
                    else{
                        return false;
                    }
                }
            }
            catch(PDOException $exception){
                echo $exception->getMessage();
            }
        }

        public function isLoggedIn(){
            if(isset($_SESSION['user_session'])){
                return true;
            }
        }

        public function redirectTo($url){
            header("Location: $url");
        }
        
        public function logOut(){
            session_destroy();
            unset($_SESSION['user_session']);
            return true;
        }

        public function register($username,$email,$password) {
        $type = 2;
        $active = 1;
		try
		{
			$new_password = password_hash($password, PASSWORD_DEFAULT);

			$stmt = $this->connection->prepare("INSERT INTO users(user_name,user_email,user_passwd,type_id,is_active)
		                                               VALUES(:username, :email, :password, :type, :active)");

			$stmt->bindparam(":username", $username);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":password", $new_password);
			$stmt->bindparam(":type", $type);
			$stmt->bindparam(":active", $active);

			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
    

?>