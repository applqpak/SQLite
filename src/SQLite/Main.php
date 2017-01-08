<?php

  class SQLiteException extends \Exception
  {
  }

  class SQLite
  {
    public function __construct($name)
    {
      return $this->createDatabase($name);
    }

    private function createDatabase($name)
    {
      $this->{$name}           = new stdClass();
      $this->{$name}->database = new PDO('sqlite:' . $name);
      $this->{$name}->database->setAttribute(PDO::ATTR_ERRMODE, ERRMODE_EXCEPTION);
      return true;
    }

    public function prepare($name, $sql)
    {
      try
      {
        if(isset($this->{$name}->database))
        {
          return $this->{$name}->stmt = $this->{$name}->database->prepare($sql);
        }
        $this->createDatabase($name);
        return $this->{$name}->stmt   = $this->{$name}->database->prepare($sql);
      }
      catch(\PDOException $e)
      {
        throw new \SQLiteException($e->getMessage());
      }
    }

    public function bind($name, $key, $value)
    {
      if(isset($this->{$name}->stmt))
      {
        $this->{$name}->stmt->bindValue(':' . $key, $value);
        return true;
      }
      throw new \SQLiteException('Use the createDatabase method.');
      return false;
    }

    public function execute($name)
    {
      try
      {
        if(isset($this->{$name}->stmt))
        {
          return $this->{$name}->stmt->execute();
        }
        throw new \SQLiteException('Use the createDatabase method.');
        return false;
      }
      catch(\PDOException $e)
      {
        throw new \SQLiteException($e->getMessage());
      }
    }

    public function fetch($name)
    {
      if(isset($this->{$name}->stmt))
      {
        return $this->{$name}->stmt->fetchAll();
      }
      throw new \SQLiteException('Use the createDatabase method.');
      return false;
    }
  }
