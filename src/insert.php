<?php

/*
  insert.php
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

require "requires.php";

// Instanciamento do banco de dados
$db = new DB();

// Inserção de alguns usuários
$users = array(
    new User(1, "Lucas", "lucasvieira@lisp.com.br",
             "Rua Alguma Coisa, 0", "3812345678"),
    new User(2, "Fulano", "fulano@exemplo.com",
             "Rua Alguma Coisa, 1", "3856781234"),
    new User(3, "Ciclano", "ciclano@exemplo.com",
             "Rua Alguma Coisa, 2", "3805639672"),
    new User(4, "Beltrano", "beltrano@exemplo.com",
             "Rua Alguma Coisa, 3", "38126746247")
);

$db->open();
foreach($users as $user) {
    $user->create($db);
}
$db->close();

// Inserção de algumas seções
$sections = array(
    new Section(1, "TI", "Corredor 0"),
    new Section(2, "Matemática", "Corredor 1"),
    new Section(3, "Biografias", "Corredor 2"),
    new Section(4, "Budismo", "Corredor 3")
);

$db->open();
foreach($sections as $section) {
    $section->create($db);
}
$db->close();


// Inserção de alguns livros
$books = array(
    new Book(1, "Structure and Interpretation of Computer Programs",
             "Abelson e Sussman", 1),
    new Book(2, "Land of Lisp", "Conrad Barski, M.D.", 1),
    new Book(3, "Real Time Collision Detection", "Christer Ericson", 1),
    new Book(4, "The Elements of Computing Systems", "Nissan e Schocken", 1),
    new Book(5, "Godel, Escher, Bach", "Douglas Hofstadter", 2),
    new Book(6, "I Am a Strange Loop", "Douglas Hogstadter", 2),
    new Book(7, "Mente Zen, Mente de Principiante", "Shunryu Suzuki", 4)
);

$db->open();
foreach($books as $book) {
    $book->create($db);
}
$db->close();


// Criação de alguns empréstimos
$db->open();
// Empresta SICP para Lucas
lend_book($db, 1, 1, 1, date('Y-m-d'));

// Empresta Land of Lisp para Lucas
lend_book($db, 1, 2, 2, date('Y-m-d'));

// Empresta Elements of Computing Systems para Fulano
lend_book($db, 2, 4, 3, date('Y-m-d'));

$db->close();
?>
