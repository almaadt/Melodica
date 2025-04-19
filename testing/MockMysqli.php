<?php
/**
 * Mock per la classe mysqli
 */
class MockMysqli
{
    public $errno = 0;
    public $error = '';
    private $duplicateErrorMode = false;
    private $generalErrorMode = false;
    private $lastQuery = '';
    private $lastParams = [];
    
    /**
     * Imposta se simulare un errore di duplicazione
     */
    public function setDuplicateErrorMode($mode)
    {
        $this->duplicateErrorMode = $mode;
        if ($mode) {
            $this->errno = 1062;
            $this->error = 'Duplicate entry';
        } else {
            $this->errno = 0;
            $this->error = '';
        }
    }
    
    /**
     * Imposta se simulare un errore generale
     */
    public function setGeneralErrorMode($mode)
    {
        $this->generalErrorMode = $mode;
        if ($mode) {
            $this->errno = 1000;
            $this->error = 'General database error';
        } else {
            $this->errno = 0;
            $this->error = '';
        }
    }
    
    /**
     * Mock del metodo prepare
     */
    public function prepare($query)
    {
        $this->lastQuery = $query;
        return new MockMysqliStatement($this);
    }
    
    /**
     * Ottieni l'ultima query preparata
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }
    
    /**
     * Imposta i parametri registrati
     */
    public function setLastParams($params)
    {
        $this->lastParams = $params;
    }
    
    /**
     * Ottieni gli ultimi parametri registrati
     */
    public function getLastParams()
    {
        return $this->lastParams;
    }
    
    /**
     * Controlla se c'è un errore di duplicazione
     */
    public function hasDuplicateError()
    {
        return $this->duplicateErrorMode;
    }
    
    /**
     * Controlla se c'è un errore generale
     */
    public function hasGeneralError()
    {
        return $this->generalErrorMode;
    }
}

/**
 * Mock per la classe mysqli_stmt
 */
class MockMysqliStatement
{
    private $mysqli;
    private $params = [];
    
    /**
     * Costruttore
     */
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }
    
    /**
     * Mock del metodo bind_param
     */
    public function bind_param($types, ...$params)
    {
        $this->params = $params;
        $this->mysqli->setLastParams($params);
        return true;
    }
    
    /**
     * Mock del metodo execute
     */
    public function execute()
    {
        if ($this->mysqli->hasDuplicateError()) {
            return false;
        }
        
        if ($this->mysqli->hasGeneralError()) {
            return false;
        }
        
        return true;
    }
}
