<?php

class DatabaseService {
    private string $host;
    private string $user;
    private string $password;
    private string $database;
    private mysqli|false $connection;

    public function __construct(string $host, string $user, string $password, string $database) {
        $this->host = $host;
        $this->user = $user;
        $this->password  = $password;
        $this->database = $database;
    }

    /**
     * @throws \Exception
     */
    public function connect() {
        $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);

        if(!$this->connection) {
            throw new \Exception("Connection not established!");
        }
    }

    /**
     * @throws \Exception
     */
    public function executeQuery(string $query) {
        if(!($results = mysqli_query($this->connection, $query))) {
            throw new \Exception('No data in database!');
        }
        return mysqli_fetch_all($results,MYSQLI_ASSOC);
    }

    public function getDatabase(): string {
        return $this->database;
    }

    public function getConnection(): mysqli {
        return $this->connection;
    }
}
