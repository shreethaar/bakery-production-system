<?php
class UserModel {
    private $db;
    private $table = 'users';
    
    public function __construct($database) {
        $this->db = $database;
    }
    /*
    public function createUser($data) {
        $sql = "INSERT INTO users (name, email, username, password, role) VALUES (:name, :email, :username, :password, :role)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role']
        ]);
    }
    */
    public function getUser($id) {
        $sql = "SELECT id, name, email, username, role, created_at FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getUserByEmail($email) {
        $sql = "SELECT id, name, email, username, role, created_at FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getUserByUsername($username) {
        // Include the password column in the SELECT statement
        $sql = "SELECT id, name, email, username, password, role, created_at FROM {$this->table} WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        // Fix the execute parameter syntax
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function createUser($data) {
        $sql = "INSERT INTO {$this->table} (name, email, username, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role']
        ]);
    }
    
    public function updateUser($id, $data) {
        $sql = "UPDATE {$this->table} SET name = ?, email = ?, username = ?, role = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['username'],
            $data['role'],
            $id
        ]);
    }
    
    public function validateLogin($username, $password) {
        $sql = "SELECT id, password FROM {$this->table} WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $this->getUser($user['id']);
        }
        return false;
    
    }

    public function getAllUsers() {
        $sql = "SELECT id, name FROM {$this->table} WHERE role = 'baker'"; // Fetch only bakers
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
}
?>
