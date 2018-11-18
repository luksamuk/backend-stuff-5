<?php

/*
  update.php
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

/* USUÁRIOS: QUATRO QUERIES */
// Recuperando os usuários.
$db->open();
$users = User::read_all($db);
$db->close();

// Trocando o endereço de todos eles
foreach($users as $user) {
    $user->set('address', 'Rua dos Bobos, número 0');
}

// Aplicando alterações
$db->open();
foreach($users as $user) {
    $user->update($db);
}
$db->close();




/* SEÇÕES: QUATRO QUERIES */
// Recuperando as seções
$db->open();
$sections = Section::read_all($db);
$db->close();

// Trocando a localização de todas elas
foreach($sections as $section) {
    $section->set('location', 'Biblioteca Nacional de Livros Bons');
}

// Aplicando alterações
$db->open();
foreach($sections as $section) {
    $section->update($db);
}
$db->close();





/* LIVROS: 14 QUERIES (7 queries, duas vezes) */
// Trocando a seção de todos os objetos para a seção de TI
$db->open();
$books = Book::read_all($db);
$db->close();

foreach($books as $book) {
    $book->set('section_id', 1);
}

// Aplicando alterações
$db->open();
foreach($books as $book) {
    $book->update($db);
}
$db->close();





// Trocando o autor de todos os livros para Chuck Norris
foreach($books as $book) {
    $book->set('author', 'Chuck Norris');
}

// Aplicando alterações
$db->open();
foreach($books as $book) {
    $book->update($db);
}
$db->close();

?>
