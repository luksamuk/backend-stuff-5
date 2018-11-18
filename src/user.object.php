<?php

/*
  user.object.php
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

class User implements DBRepr
{
    /* CAMPOS */
    private $values;


    /* CTOR, DTOR */
    // Instâncias de User poderão ser criadas tanto pelo programador, através
    // da construção de um novo objeto, quanto pelos métodos estáticos da classe
    public function __construct($id, $name, $email, $address, $phone)
    {
        $this->values = array(
            'user_id'      => $id,
            'user_name'    => $name,
            'user_email'   => $email,
            'user_address' => $address,
            'user_phone'   => $phone
        );
    }

    public function __destruct() {}

    
    /* MÉTODOS DO OBJETO */
    public function create($db)
    {
        $query = "INSERT INTO users (
                      user_id,
                      user_name,
                      user_email,
                      user_address,
                      user_phone
                  )
                  VALUES (
                      " . $this->values['user_id']      . ",
                      \"" . $this->values['user_name']    . "\",
                      \"" . $this->values['user_email']   . "\",
                      \"" . $this->values['user_address'] . "\",
                      \"" . $this->values['user_phone']   . "\"
                  );";
        // Aplica-se a query, assume-se a conexão aberta
        return $db->query($query);
    }

    
    public function update($db)
    {
        $query = "UPDATE users SET
                      user_name    = \"" . $this->values['user_name']    . "\",
                      user_email   = \"" . $this->values['user_email']   . "\",
                      user_address = \"" . $this->values['user_address'] . "\",
                      user_phone   = \"" . $this->values['user_phone']   . "\"
                  WHERE user_id = " . $this->values['user_id'] . ";";
        return $db->query($query);
    }

    
    public function set($field_name, $field_value)
    {
        $key = "user_" . $field_name;
        if(array_key_exists($key, $this->values)) {
            $this->values[$key] = $field_value;
        }
        else {
            echo "Error: Field '$field_name' does not exist in User";
        }
    }

    public function delete($db)
    {
        // Pequeno truque... XP
        self::delete_by_id($this->values['user_id'], $db);
    }

    public function get_raw()
    {
        return $this->values;
    }


    /* MÉTODOS ESTÁTICOS */
    public static function read_by_id($id, $db)
    {
        $query = "SELECT
                      u.user_id,
                      u.user_name,
                      u.user_email,
                      u.user_address,
                      u.user_phone,
                  FROM     users as u
                  WHERE    u.user_id = '$id'
                  ORDER BY u.user_name DESC;";
        
        $data = $db->fetch_one($query);
        
        if($data) {
            return new User($data['user_id'],
                            $data['user_name'],
                            $data['user_email'],
                            $data['user_address'],
                            $data['user_phone']);
        }
    }

    
    public static function read_all($db)
    {
        $query = "SELECT
                      u.user_id,
                      u.user_name,
                      u.user_email,
                      u.user_address,
                      u.user_phone
                  FROM     users AS u
                  ORDER BY u.user_name DESC;";
        $data = $db->fetch($query);

        $ret = array();
        foreach($data as $item) {
            array_push($ret,
                       new User($item['user_id'],
                                $item['user_name'],
                                $item['user_email'],
                                $item['user_address'],
                                $item['user_phone']));
        }
        return $ret;
    }


    public static function delete_by_id($id, $db)
    {
        $query = "DELETE FROM users
                  WHERE user_id = '$id';";
        return $db->query($query);
    }
}

?>
