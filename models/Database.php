<?php

/*******************************************
 * 
 *     A General Purpose Database Class
 *     Connect to database
 *     Ta emot databas, användarnamn, password och namn på servern
 *     Skapa variabel $dsn som innehåller data source name
 *     Skapa en PDO (php data object) och ta emot $dsn username och password  
 *     Sätter attribut på errorhantering
 *      
 ******************************************/

class Database
{

    private $conn = null;

    public function __construct($database, $username = "root", $password = "root", $servername = "localhost")
    {
        // Data Source Name
        $dsn = "mysql:host=$servername;dbname=$database;charset=UTF8";

        try {
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * En instansmetod som exekverar en PDO-sats
     * Ta emot $statement från controller och input parametrar 
     * Vi kör prepare som är en PDO metod och kör sedan PDO metod execute
     * Error hantering om PDO inte exekveras korrekt
     */
    private function execute($statement, $input_parameters = [])
    {
        try {
            $stmt = $this->conn->prepare($statement);
            $stmt->execute($input_parameters);
            return $stmt;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
            throw new Exception($e->getMessage());
        }
    }

    /**
     * SELECT
     * Kör execute metoden
     * Returnerar en associativ array   
     */
    public function select($statement, $input_parameters = [])
    {
        $stmt = $this->execute($statement, $input_parameters);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * INSERT
     * Kör execute
     * Returnera Id på senaste insert
     */
    public function insert($statement, $input_parameters = [])
    {
        $this->execute($statement, $input_parameters);
        return $this->conn->lastInsertId();
    }

    /**
     * UPDATE
     * Kör execute 
     * Connecta till databasen skicka med nya input_parametrar till ett objekt
     * $statement är Update
     */
    public function update($statement, $input_parameters = [])
    {

        $this->execute($statement, $input_parameters);
    }

    /**
     * DELETE
     * Kör execute
     * $statement är Delete 
     * $input_parameters är id på objektet
     */
    public function delete($statement, $input_parameters = [])
    {
        $this->execute($statement, $input_parameters);
    }
}