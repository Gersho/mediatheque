<?php 

function insert_new_book($book_data)
{
        $id = insert_new_media('Book');
         
        $query = "INSERT INTO books 
        (id, title, genre, stock, author, isbn, pages, published_year, summary)
        VALUES (?,?,?,?,?,?,?,?,?)";

                if (db_execute(
                    $query,
                    [
                        $id,
                        $book_data['title'],
                        $book_data['genre'],
                        $book_data['stock'],
                        $book_data['author'],
                        $book_data['isbn'],
                        $book_data['pages'],
                        $book_data['published_year'],
                        $book_data['summary'],
                    ]
                )) {
                    set_flash('success','Média ajouté avec succès');
                    return db_last_insert_id();
                }
                return false;
    }

function get_book_by_id($id)
{
    $query = "SELECT * FROM  books WHERE id = ? LIMIT 1";
    return db_select_one($query, [$id]);
}
