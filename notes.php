<?php
require_once 'general_functions.php';



// EXTRACT
//
if(isset($_GET['extract'])){
    $userID = $_COOKIE['logon_status'];
        try {
            $dbConn = getConnection();

            $extractNotesQuery = "SELECT n_user_id, note_id, note_title, note_text, date_taken 
                                FROM notes
                                WHERE n_user_id = :id
                                ORDER BY date_taken DESC";
            $query = $dbConn->prepare($extractNotesQuery);
            $query->execute(array(':id' => $userID));


            $output = '';
            while($note = $query->fetchObject()){
                $output .= '
                    <div class="d-flex justify-content-between mb-2">
                        <h5>'.$note->note_title.'</h5>
                        <div>

                            <!-- TODO Delete note function-->

                            <img class="trash" src="data/trash.png" onclick="delete_note('.$note->note_id.')" alt="trash" width="20"/>
                        </div>
                    </div>
                    <p>'.$note->note_text.'</p>
                    <hr class="solid">';
            }

            echo $output;

        } catch (Exception $e) {
            $ermessage = "Failed to extract the notes from the database";
            exceptionHandler($e, $ermessage);
        }
}




// DELETE
if(isset($_GET['delete_note'])&& isset($_GET['noteID'])){
    $userID = $_COOKIE['logon_status'];
    $noteID = $_GET['noteID'];
    try {
        $dbConn = getConnection();

        $deleteNoteQuery = "DELETE FROM notes
                                WHERE n_user_id = :id AND note_id=:nid";
        $query = $dbConn->prepare($deleteNoteQuery);
        $query->execute(array(':id' => $userID, ':nid' => $noteID));

        echo true;


    } catch (Exception $e) {
        $ermessage = "Failed to delete the note from the database";
        exceptionHandler($e, $ermessage);
    }

}


// ADD
if(isset($_GET['add_note'])) {

    // TITLE
    $note_title = filter_has_var(INPUT_POST, 'note_title') ? $_POST['note_title'] : null;
    $note_title = filter_var($note_title, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    // TEXT
    $note_text = filter_has_var(INPUT_POST, 'note_text') ? $_POST['note_text'] : null;
    $note_text = filter_var($note_text, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $userID = $_COOKIE['logon_status'];

    try {
        $dbConn = getConnection();

        $addNoteQuery = "INSERT INTO notes(n_user_id, note_title, note_text)
                            VALUES (:id, :title, :text)";
        $query = $dbConn->prepare($addNoteQuery);
        $query->execute(array(':id' => $userID, ':title' => $note_title, ':text' => $note_text));

    } catch (Exception $e) {
        $ermessage = "Failed to add a note to the database";
        exceptionHandler($e, $ermessage);
    }
}