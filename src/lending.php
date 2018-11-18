<?php

/*
  lending.php
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

/*
 * O ato do empréstimo de um livro é um ato de estabelecimento de uma relação,
 * apenas. Isto significa que não precisamos de um objeto "lending" em si, mas
 * sim de operações que realizem as atribuições de um empréstimo a um usuário
 * e também que desfaçam este empréstimo.
*/

// Realiza o empréstimo de um livro a um usuário.
// Requer as IDs de um usuário e de um livro existentes.
// Também são requeridos a ID do empréstimo que deseja-se criar, bem como
// a data de retorno do livro.
//
// Esta função criará um empréstimo e estabelecerá uma relação entre o usuário
// e o livro.
function lend_book($db, $user_id, $book_id, $borrowing_id, $return_date)
{
    // Crie um borrowing para tal.
    $borrowing = new Borrowing($borrowing_id,
                               date("Y-m-d H:i:s"),
                               $user_id,
                               $return_date);
    $borrowing->create($db);

    // Crie a relação de empréstimo
    $query = "INSERT INTO lendings (
                  lending_book_id,
                  lending_borrowing_id
              )
              VALUES ('$book_id', '$borrowing_id');";
    return $db->query($query);
}


// Devolve um livro à biblioteca, removendo a relação de empréstimo entre
// o usuário e o livro.
function return_book($db, $borrowing_id)
{
    // Tenta remover a relação de empréstimo diretamente
    $query = "DELETE FROM lendings
              WHERE lending_borrowing_id = '$borrowing_id';";
    if($db->query($query)) {
        // Se a relação de empréstimo existia e foi deletada com sucesso,
        // agora podemos remover o empréstimo em si.
        Borrowing::delete_by_id($borrowing_id, $db);
    }
}

// Retorna um array com todas as relações usuário x empréstimo.
// O array possui IDs de livro como chave, e a ID do empréstimo
// como valor associado.
function read_all_relations($db)
{
    $query = "SELECT * FROM lendings;";
    $ret = $db->fetch($query);

    if($ret) {
        $relations = array();
        foreach($ret as $relation) {
            $relations[$relation['lending_book_id']] = $relation['lending_borrowing_id'];
        }
        return $relations;
    }
}

?>
