<?php

/*
  borrowing.object.php
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

class Borrowing implements DBRepr
{
    /* CAMPOS */
    private $values;


    /* CTOR, DTOR */
    public function __construct($id, $datetime, $user_id, $devolution)
    {
        $this->values = array(
            'borrowing_id'         => $id,
            'borrowing_datetime'   => $datetime,
            'borrowing_user_id'    => $user_id,
            'borrowing_devolution' => $devolution
        );
    }

    public function __destruct() {}


    /* MÉTODOS DO OBJETO */
    public function create($db)
    {
        $query = "INSERT INTO borrowings (
                      borrowing_id,
                      borrowing_datetime,
                      borrowing_user_id,
                      borrowing_devolution
                  )
                  VALUES (
                      " . $this->values['borrowing_id'] . ",
                      \"" . $this->values['borrowing_datetime'] . "\",
                      " . $this->values['borrowing_user_id'] . ",
                      \"" . $this->values['borrowing_devolution'] . "\"
                  );";
        return $db->query($query);
    }


    public function update($db)
    {
        $query =
               "UPDATE borrowings SET
                  borrowing_datetime = \"" . $this->values['borrowing_datetime'] . "\",
                  borrowing_user_id  = " . $this->values['borrowing_user_id'] . ",
                  borrowing_devolution = \"" . $this->values['borrowing_devolution'] . "\"
               WHERE borrowing_id = " . $this->values['borrowing_id'] . ";";
        return $db->query($query);
    }

    
    public function set($field_name, $field_value)
    {
        $key = "borrowing_" . $field_name;
        if(array_key_exists($key, $this->values)) {
            $this->values[$key] = $field_value;
        }
        else {
            echo "Error: Field '$field_name' does not exist in Borrowing";
        }
    }

    public function delete($db)
    {
        self::delete_by_id($this->values['borrowing_id'], $db);
    }

    public function get_id()
    {
        return $this->values['borrowing_id'];
    }

    public function get_raw()
    {
        return $this->values;
    }


    /* MÉTODOS ESTÁTICOS */
    public static function read_by_id($id, $db)
    {
        $query = "SELECT
                      b.borrowing_id,
                      b.borrowing_datetime,
                      b.borrowing_user_id,
                      b.borrowing_devolution
                  FROM     borrowings AS b
                  WHERE    b.borrowing_id = '$id'
                  ORDER BY b.borrowing_datetime DESC;";

        $data = $db->fetch_one($query);

        if($data) {
            return new Borrowing($data['borrowing_id'],
                                 $data['borrowing_datetime'],
                                 $data['borrowing_user_id'],
                                 $data['borrowing_devolution']);
        }
    }


    public static function read_all($db)
    {
        $query = "SELECT
                      b.borrowing_id,
                      b.borrowing_datetime,
                      b.borrowing_user_id,
                      b.borrowing_devolution
                  FROM     borrowings AS b
                  ORDER BY b.borrowing_datetime DESC;";

        $data = $db->fetch($query);
        $ret = array();

        foreach($data as $item) {
            array_push($ret,
                       new Borrowing($item['borrowing_id'],
                                     $item['borrowing_datetime'],
                                     $item['borrowing_user_id'],
                                     $item['borrowing_devolution']));
        }

        return $ret;
    }


    public static function delete_by_id($id, $db)
    {
        $query = "DELETE FROM borrowings
                  WHERE borrowing_id = '$id';";
        return $db->query($query);
    }
}

?>
