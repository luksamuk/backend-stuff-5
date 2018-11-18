<?php

/*
  section.object.php
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

class Section implements DBRepr
{
    /* CAMPOS */
    private $values;


    /* CTOR, DTOR */
    public function __construct($id, $description, $location)
    {
        $this->values = array(
            'section_id'          => $id,
            'section_description' => $description,
            'section_location'    => $location
        );
    }

    public function __destruct() {}

    /* MÉTODOS DO OBJETO */
    public function create($db)
    {
        $query = "INSERT INTO sections (
                      section_id,
                      section_description,
                      section_location
                  )
                  VALUES (
                      " . $this->values['section_id'] . ",
                      \"" . $this->values['section_description'] . "\",
                      \"" . $this->values['section_location'] . "\"
                  );";
        return $db->query($query);
    }

    public function update($db)
    {
        $query = "UPDATE sections SET
                      section_description =
                          \"" . $this->values['section_description'] . "\",
                      section_location   = \"" .
                                $this->values['section_location'] . "\"
                  WHERE section_id = " . $this->values['section_id'] . ";";
        return $db->query($query);
    }

    public function set($field_name, $field_value)
    {
        $key = "section_" . $field_name;
        if(array_key_exists($key, $this->values)) {
            $this->values[$key] = $field_value;
        }
        else {
            echo "Error: Field '$field_name' does not exist in Section";
        }
    }

    public function delete($db)
    {
        self::delete_by_id($this->values['section_id'], $db);
    }

    public function get_raw()
    {
        return $this->values;
    }


    /* MÉTODOS ESTÁTICOS */
    public static function read_by_id($id, $db)
    {
        $query = "SELECT
                      s.section_id,
                      s.section_description,
                      s.section_location
                  FROM     sections AS s
                  WHERE    s.section_id = '$id'
                  ORDER BY s.section_description DESC;";
        
        $data = $db->fetch_one($query);
        
        if($data) {
            return new Section($data['section_id'],
                               $data['section_description'],
                               $data['section_location']);
        }
    }

    public static function read_all($db)
    {
        $query = "SELECT
                      s.section_id,
                      s.section_description,
                      s.section_location
                  FROM     sections AS s
                  ORDER BY s.section_description DESC;";
        
        $data = $db->fetch($query);
        $ret = array();
        
        foreach($data as $item) {
            array_push($ret,
                       new Section($item['section_id'],
                                   $item['section_description'],
                                   $item['section_location']));
        }

        return $ret;
    }

    public static function delete_by_id($id, $db)
    {
        $query = "DELETE FROM sections WHERE section_id = '$id';";
        return $db->query($query);
    }
}

?>
