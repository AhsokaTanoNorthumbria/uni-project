<?php
require_once 'general_functions.php';

// EXTRACT
if(isset($_GET['extract'])){
    $userID = $_COOKIE['logon_status'];
    try {
        $dbConn = getConnection();

        $extractTasksQuery = "SELECT pl_user_id, task_id, task_title, task_details, date_taken 
                                FROM planner
                                WHERE pl_user_id = :id
                                ORDER BY date_taken DESC";
        $query = $dbConn->prepare($extractTasksQuery);
        $query->execute(array(':id' => $userID));


        $output = '';
        while($task = $query->fetchObject()){
            $output .= '
                    <div class="d-flex justify-content-between">
                        <h5><b>'.$task->task_title.'</b></h5>
                        <div>

                            <!-- TODO Delete task function-->

                            <img class="trash" onclick="delete_task('.$task->task_id.')" src="data/trash.png" alt="trash" width="20"/>
                        </div>
                    </div>
                    <p class="fs-6">'.$task->task_details.'</p>
                    <hr class="solid">';
        }

        echo $output;

    } catch (Exception $e) {
        $ermessage = "Failed to extract the tasks from the database";
        exceptionHandler($e, $ermessage);
    }
}


// DELETE
if(isset($_GET['delete_task'])&& isset($_GET['taskID'])){
    $userID = $_COOKIE['logon_status'];
    $noteID = $_GET['taskID'];
    try {
        $dbConn = getConnection();

        $deleteNoteQuery = "DELETE FROM planner
                                WHERE pl_user_id = :id AND task_id=:tid";
        $query = $dbConn->prepare($deleteNoteQuery);
        $query->execute(array(':id' => $userID, ':tid' => $noteID));

        echo true;


    } catch (Exception $e) {
        $ermessage = "Failed to delete a task from the database";
        exceptionHandler($e, $ermessage);
    }

}



// ADD
if(isset($_GET['add_task'])) {

    // TITLE
    $task_title = filter_has_var(INPUT_POST, 'task_title') ? $_POST['task_title'] : null;
    $task_title = filter_var($task_title, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    // TEXT
    $task_text = filter_has_var(INPUT_POST, 'task_text') ? $_POST['task_text'] : null;
    $task_text = filter_var($task_text, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $userID = $_COOKIE['logon_status'];

    try {
        $dbConn = getConnection();

        $addNoteQuery = "INSERT INTO planner(pl_user_id, task_title, task_details)
                            VALUES (:id, :title, :text)";
        $query = $dbConn->prepare($addNoteQuery);
        $query->execute(array(':id' => $userID, ':title' => $task_title, ':text' => $task_text));

    } catch (Exception $e) {
        $ermessage = "Failed to add a task to the database";
        exceptionHandler($e, $ermessage);
    }
}