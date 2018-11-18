<?php

/*
  db.object.php
  Copyright (c) 2018 Lucas Vieira <lucasvieira@lisp.com.br>

  This file is distributed under the MIT License.
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.
*/

define("DB_HOSTI",     "localhost");
define("DB_USERNAMEI", "root");
define("DB_PASSWORDI", "");
define("DB_DATABASEI", "treinamento-backend");

class DB
{
    /* CAMPOS */
    private $dbi;

    /* CTOR, DTOR */
    public function __construct()
    {
        $this->dbi;
    }

    
    public function __destruct()
    {
        $this->dbi = NULL;
    }


    /* MÉTODOS DE CONTROLE DE ACESSO */
    public function open()
    {
        $this->dbi = new PDO("mysql:host=" . DB_HOSTI . ";dbname="  .
                               DB_DATABASEI  . ";charset=utf8mb4",
                             DB_USERNAMEI,
                             DB_PASSWORDI);
        $this->dbi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->dbi->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    
    public function close()
    {
        $this->dbi = NULL;
    }

    /* MÉTODOS DE RECUPERAÇÃO DE DADOS */
    public function query($query)
    {
        return $this->__attempt_query($query);
    }

    
    public function fetch($query)
    {
        $statement = $this->__attempt_query($query);
        
        if($statement) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }


    public function fetch_one($query)
    {
        $statement = $this->__attempt_query($query);
        
        if($statement) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }


    /* MÉTODOS INTERNOS */
    private function __attempt_query($query)
    {
        try {
            $statement = $this->dbi->query($query);
            return $statement;
        }
        catch(PDOException $e) {
            echo "Error performing query: " . $e . "\nOn query: " . $query;
            return NULL;
        }
    }

    
}

?>
