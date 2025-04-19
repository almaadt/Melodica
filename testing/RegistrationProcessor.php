<?php
/**
 * Classe che gestisce la registrazione degli utenti
 */
class RegistrationProcessor
{
    private $db;
    
    /**
     * Costruttore
     * 
     * @param MockDatabase $db Database mock o reale
     */
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    /**
     * Elabora la registrazione di un utente
     * 
     * @param array $postData I dati del form
     * @return array Risultato dell'operazione
     */
    public function processRegistration($postData)
    {
        $email = $postData['email'];
        $username = $postData['username'];
        $password = $postData['password'];
        $password1 = $postData['password1'];

        // Validazione base
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => "error", "message" => "Formato email non valido."];
        }
        
        if (strlen($username) < 3) {
            return ["status" => "error", "message" => "Lo username deve avere almeno 3 caratteri."];
        }
        
        if (strlen($password) < 6) {
            return ["status" => "error", "message" => "La password deve avere almeno 6 caratteri."];
        }
        
        if (($password) != ($password1)) {
            return ["status" => "error", "message" => "Le password digitate devono corrispondere."];
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  // Hash della password

        try {
            // Inserimento nel database usando il mock
            $this->db->insert($email, $username, $hashedPassword);
            return ["status" => "success", "message" => "Registrazione completata con successo! Torna al Login per effettuare l'accesso."];
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return ["status" => "error", "message" => "Errore: L'e-mail o lo username esistono già."];
            } else {
                return ["status" => "error", "message" => "Errore durante la registrazione: " . $e->getMessage()];
            }
        }
    }
}
