<?php
/**
 * Versione della classe di registrazione che usa mysqli invece di PDO
 */
class RegistrationProcessorMysqli
{
    private $mysqli;
    
    /**
     * Costruttore
     * 
     * @param mysqli $mysqli Connessione mysqli
     */
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
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
            // Preparazione della query con mysqli
            $stmt = $this->mysqli->prepare("INSERT INTO utenti (email, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $username, $hashedPassword);
            $result = $stmt->execute();
            
            if ($result) {
                return ["status" => "success", "message" => "Registrazione completata con successo! Torna al Login per effettuare l'accesso."];
            } else {
                // Verifica se l'errore è di duplicazione
                if ($this->mysqli->errno == 1062) { // Codice errore di duplicazione mysqli
                    return ["status" => "error", "message" => "Errore: L'e-mail o lo username esistono già."];
                } else {
                    return ["status" => "error", "message" => "Errore durante la registrazione: " . $this->mysqli->error];
                }
            }
        } catch (Exception $e) {
            return ["status" => "error", "message" => "Errore durante la registrazione: " . $e->getMessage()];
        }
    }
}
