<?php

/*
  delete.php
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

/*
 * O objetivo aqui é apagar todos os dados anteriormente registrados.
 * Devido a isto, é importante ressaltar a importância da ordem das deleções, de
 * acordo com o uso das foreign keys e as dependências. A ordem deverá ser:
 *
 * - Lendings (não-objetos): deletados através da desassociação de um usuário a
 *   um livro;
 * - Borrowings: deletados automaticamente após a deleção dos lendings;
 * - Books;
 * - Users e Sections.
*/

$db->open();

// Recupera todas as informações de relevância.
$users      = User::read_all($db);
$borrowings = Borrowing::read_all($db);
$books      = Book::read_all($db);
$sections   = Section::read_all($db);

// Retorna todos os livros tomados emprestado.
// Colateralmente deleta todos os Lendings e Borrowings
foreach($borrowings as $borrowing) {
    return_book($db, $borrowing->get_id());
}

// Deleta todos os livros
foreach($books as $book) {
    $book->delete($db);
}

// Deleta todas as seções
foreach($sections as $section) {
    $section->delete($db);
}

// Deleta todos os usuários
foreach($users as $user) {
    $user->delete($db);
}

$db->close();
?>
