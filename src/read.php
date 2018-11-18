<!--
  read.php
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
-->

<!DOCTYPE html>
<html>
  <body>
    <h1>Dump Legível do Banco de Dados</h1>
    <p>NOTA: IDs e Foreign Keys não serão mostradas.</p>
    <?php

    require "requires.php";

    // Instanciamento do banco de dados
    $db = new DB();

    /*
     * Nenhum framework está sendo utilizado aqui. Ao invés disso, estão sendo
     * utilizadas tags HTML5 padrão e um dump inteligente, ligeiramente similar
     * ao utilizado na última atividade.
     */

    // Começamos recebendo todos os dados do banco de dados, de uma vez.
    $db->open();

    $users      = User::read_all($db);
    $borrowings = Borrowing::read_all($db);
    $books      = Book::read_all($db);
    $sections   = Section::read_all($db);
    $lendings   = read_all_relations($db);
    
    $db->close();

    // Função auxiliar para renderização de tabela, transplantada parcialmente
    // do exercício anterior... favor não reparar muito.
    function render_table($map)
    {
	echo "<table style='width:100%'>";
	
	/*     NOMES DAS COLUNAS   */
	echo "<tr>";
	foreach($map[0] as $key => $value) {
            echo "<th>" . $key . "</th>";
	}
	echo "</tr>";
	
	/*       CAMPOS     */
	foreach($map as $entry) {
            echo "<tr>";
            foreach($entry as $key => $field) {
		echo "<td>" . $field . "</td>";
            }
            echo "</tr>";
	}
	
	echo "</table>";
    }


    

    // Teremos duas tabelas:
    // Nome, E-mail, Endereço, Telefone
    // Nome do Livro, Autor, Seção, Locatário (+ data de locação e devolução)

    // A primeira tabela é simples, só precisamos utilizar os dados de
    // usuários e agrupá-los de forma adequada.
    function regroup_users($users)
    {
	$re_users = array();
	foreach($users as $user) {
	    array_push($re_users,
		       array(
			   "Nome"     => $user->get_raw()['user_name'],
			   "E-mail"   => $user->get_raw()['user_email'],
			   "Endereço" => $user->get_raw()['user_address'],
			   "Telefone" => $user->get_raw()['user_phone']
		       ));
	}
	return $re_users;
    }


    echo "<section>";
    echo "<h3>Relação de Usuários</h3>";
    render_table(regroup_users($users));
    echo "</section>";


    echo "<p></p>";
    

    // A segunda tabela dá um pouco mais de trabalho, uma vez que cada
    // livro precisa percorrer a lista de usuários e comparar a ID dos
    // mesmos para definir se este é o locatário do livro.

    // Para facilitar esta operação, crio aqui uma função que retorna
    // o nome de um usuário através de uma ID.
    // Não é nem de longe a solução mais eficiente, mas estou evitando
    // acessar o BD de novo.
    function get_borrower($borrowing_id, $borrowings, $users)
    {
	foreach($borrowings as $borr) {
	    $raw_borr = $borr->get_raw();
	    if($raw_borr['borrowing_id'] === $borrowing_id) {
		$user_id = $raw_borr['borrowing_user_id'];

		// Encontre o usuário "sortudo"
		foreach($users as $user) {
		    $raw_usr = $user->get_raw();
		    if($raw_usr['user_id'] === $user_id) {
			// Retorne a string completa que queremos.
			// Ela será mostrada no campo específico da
			// segunda tabela.
			return $raw_usr['user_name'] .
			       " (Data de Locação: " .
			       $raw_borr['borrowing_datetime'] .
			       "; Data de Devolução: " .
			       $raw_borr['borrowing_devolution'] .
			       ")";
		    }
		}
		
		break; // ...provavelmente inalcançável :P
	    }
	}

	return "Nenhum";
    }

    // Precisamos de mais uma função auxiliar que reagrupa as seções.
    // A ID da seção será a chave, e a sua descrição + localização
    // será os dados.
    function regroup_sections($sections)
    {
	$re_sections = array();
	foreach($sections as $section) {
	    $raw = $section->get_raw();
	    $re_sections[$raw['section_id']] =
		$raw['section_description'] .
		" (" . $raw['section_location'] . ")";
	}
	return $re_sections;
    }

    // Agora, podemos montar nossa tabela de livros.
    function regroup_books($books, $lendings, $borrowings, $sections, $users)
    {
	$re_sections = regroup_sections($sections);

	$re_books = array();

	foreach($books as $book) {
	    $raw_book = $book->get_raw();
	    $borrower = "Nenhum";
	    $book_id = $raw_book['book_id'];
	    if(array_key_exists($book_id, $lendings)) {
		$borrower = get_borrower($lendings[$book_id],
					 $borrowings,
					 $users);
	    }
	    $book_section = $re_sections[$raw_book['book_section_id']];

	    array_push($re_books,
		       array(
			   "Nome"      => $raw_book['book_title'],
			   "Autor"     => $raw_book['book_author'],
			   "Seção"     => $book_section,
			   "Locatário" => $borrower
		       ));
	}

	return $re_books;
    }

    echo "<section>";
    echo "<h3>Relação de Livros</h3>";
    render_table(regroup_books($books, $lendings, $borrowings,
			       $sections, $users));
    echo "</section>";

    ?>
  </body>
</html>
