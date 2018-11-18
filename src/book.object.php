<?php

/*
  book.object.php
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

class Book implements DBRepr
{
    /* CAMPOS */
    private $values;

    /* CTOR, DTOR */
    public function __construct($id, $title, $author, $section_id)
    {
        $this->values = array(
            'book_id'         => $id,
            'book_title'      => $title,
            'book_author'     => $author,
            'book_section_id' => $section_id
        );
    }

    public function __destruct() {}


    /* MÉTODOS DO OBJETO */
    public function create($db)
    {
        $query = "INSERT INTO books (
                      book_id,
                      book_title,
                      book_author,
                      book_section_id
                  )
                  VALUES (
                      " . $this->values['book_id'] . ",
                      \"" . $this->values['book_title'] . "\",
                      \"" . $this->values['book_author'] . "\",
                      " . $this->values['book_section_id'] . "
                  );";
        return $db->query($query);
    }


    public function update($db)
    {
        $query = "UPDATE books SET
                      book_title      = \"" . $this->values['book_title'] . "\",
                      book_author     = \"" . $this->values['book_author'] . "\",
                      book_section_id = " . $this->values['book_section_id'] . "
                  WHERE book_id = " . $this->values['book_id'] . ";";
        return $db->query($query);
    }

    public function set($field_name, $field_value)
    {
        $key = "book_" . $field_name;
        if(array_key_exists($key, $this->values)) {
            $this->values[$key] = $field_value;
        }
        else {
            echo "Error: Field '$field_name' does not exist in Book";
        }
    }

    public function delete($db)
    {
        self::delete_by_id($this->values['book_id'], $db);
    }

    public function get_raw()
    {
        return $this->values;
    }


    /* MÉTODOS ESTÁTICOS */
    public static function read_by_id($id, $db)
    {
        $query = "SELECT
                      b.book_id,
                      b.book_title,
                      b.book_author,
                      b.book_section_id
                  FROM     books AS b
                  WHERE    b.book_id = '$id'
                  ORDER BY b.book_title DESC;";
        
        $data = $db->fetch_one($query);
        
        if($data) {
            return new Book($data['book_id'],
                            $data['book_title'],
                            $data['book_author'],
                            $data['book_section_id']);
        }
    }

    public static function read_all($db)
    {
        $query = "SELECT
                      b.book_id,
                      b.book_title,
                      b.book_author,
                      b.book_section_id
                  FROM     books AS b
                  ORDER BY b.book_title DESC;";
        
        $data = $db->fetch($query);

        $ret = array();
        
        foreach($data as $item) {
            array_push($ret,
                       new Book($item['book_id'],
                                $item['book_title'],
                                $item['book_author'],
                                $item['book_section_id']));
        }
        return $ret;
    }

    public static function delete_by_id($id, $db)
    {
        $query = "DELETE FROM books WHERE book_id = '$id';";
        return $db->query($query);
    }
}

?>
