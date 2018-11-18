<?php

/*
  dbrepr.object.php
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


// Interface representando métodos a serem implementados para um objeto
// qualquer do banco de dados.
interface DBRepr
{
    // Realiza o "commit" do objeto criado para o banco de dados.
    public function create($db);

    // Atualiza os dados alterados no objeto com relação ao banco
    // de dados.
    public function update($db);

    // Substitui Set. Cada objeto do DB manterá um array
    // com os valores de cada campo, para manipulação abstrata.
    // Dessa forma, podemos redefinir um valor sem redefinir o resto
    public function set($field_name, $field_value);

    // Substitui Delete. Deleta o objeto no banco de dados.
    public function delete($db);

    // Retorna os elementos crus do objeto em forma de array.
    public function get_raw();

    // Substitui ReadRMI. Faz uma procura por ID pelo objeto, cria-o
    // e retorna-o com os dados encontrados. Este método deverá retornar
    // apenas uma instância.
    public static function read_by_id($id, $db);

    // Substitui ReadAll. Recupera todos os objetos do banco de dados e
    // retorna um array contendo-os.
    public static function read_all($db);

    // Substitui DeleteRMI. Deleta o objeto por ID no banco de dados.
    public static function delete_by_id($id, $db);
}

?>
