<?php
    $tasks = [
        "To Do" => [],
        "In Progress" => [],
        "Done" => []
    ];

    $tasks_counters = [
        "To Do" => 0,
        "In Progress" => 0,
        "Done" => 0
    ];

    $tasks_priorities = [
        "Low" => 1,
        "Medium" => 2,
        "High" => 3,
        "Critical" => 4
    ];

    $tasks_statuses = [
        "To Do" => 1,
        "In Progress" => 2,
        "Done" => 3
    ];

    $tasks_types = [
        "Feature" => 1,
        "Bug" => 2
    ];

    $icons = [
        "To Do" => '<i class="bi bi-question-circle"></i>',
        "In Progress" => '<i class="spinner-border spinner-border-sm"></i>',
        "Done" => '<i class="bi bi-check-circle"></i>'
    ];

    include('database.php');
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();

    function getTasks()
    {
        global $conn, $tasks, $tasks_counters;
        $sql = "
                SELECT * FROM Tasks
                JOIN Statuses ON status_id = statuses_id
                JOIN Types ON type_id = types_id
                JOIN Priorities ON priority_id = priorities_id
                ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $status = $row["status"];
                $tasks_counters[$status]++;
                array_push($tasks[$status], $row);
            }
        }
    }

    function addTasks($status)
    {
        global $tasks, $icons;
        foreach($tasks[$status] as $task) {
            $sub_description = substr($task["description"], 0, 40);
            $s = "<button id=\"${task['id']}\" data-date=\"${task['task_datetime']}\" data-status=\"${task['status']}\" class=\"border-0 w-100 py-2 px-1 d-flex task-card\">
                    <div class=\"text-success px-2 fs-5\">
                        ${icons[$status]}
                    </div>
                    <div class=\"text-start\">
                        <div class=\"title fw-bolder fs-13px\">${task['title']}</div>
                        <div class=\"fs-6\">
                            <div class=\"date text-secondary\">#${task['id']} created in ${task['task_datetime']}</div>
                            <div class=\"description\" title=\"${task['description']}\">
                                ${task['description']}</div>
                        </div>
                        <div class=\"py-2\">
                            <span class=\"priority bg-primary text-white rounded-2 p-1 px-2\">${task['priority']}</span>
                            <span class=\"type bg-light-600 rounded-2 p-1 px-2\">${task['type']}</span>
                        </div>
                    </div>
                </button>";
            echo $s;
        }
    }

    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    function validateInt($value, $min_range = null, $max_range = null)
    {
        $options = [];
        if ($min_range)
            $options["min_range"] = $min_range;
        if ($max_range)
            $options["max_range"] = $max_range;
        if (!filter_var($value, FILTER_VALIDATE_INT, array("options" => $options)))
            return false;
        return true;
    }

    function taskFromPost()
    {
        global $tasks_priorities, $tasks_statuses, $tasks_types;

        $task = [];

        if (isset($_POST["update"])) {
            $value = $_POST["task-id"];
            if (!validateInt($value, 1)) {
                $_SESSION["error"] = "error updating task !";
                return null;
            }
        }
        $task["task_id"] = $value;

        $value = $tasks_types[$_POST["task-type"]];
        if (!validateInt($value, 1, 2)) {
            $_SESSION["error"] = "error task type !";
            return null;
        }
        $task["type_id"] = $value;

        $value = $tasks_priorities[$_POST["task-priority"]];
        if (!validateInt($value, 1, 4)) {
            $_SESSION["error"] = "error task priority !";
            return null;
        }
        $task["priority_id"] = $value;

        $value = $tasks_statuses[$_POST["task-status"]];
        if (!validateInt($value, 1, 3)) {
            $_SESSION["error"] = "error task status !";
            return null;
        }
        $task["status_id"] = $value;

        $value = $_POST["task-date"];
        if (!validateDate($value)) {
            $_SESSION["error"] = "error task date !";
            return null;
        }
        $task["task_datetime"] = $value;

        $task["title"] = htmlspecialchars(strip_tags($_POST["task-title"]));
        $task["description"] = htmlspecialchars(strip_tags($_POST["task-description"]));

        return $task;
    }

    function saveTask()
    {
        global $tasks_priorities, $tasks_statuses, $tasks_types, $conn;

        if ($task = taskFromPost()) {
            $sql = "
                    INSERT INTO Tasks (title, task_datetime, type_id, status_id, priority_id, description)
                    VALUES (\"${task['title']}\", \"${task['task_datetime']}\", ${task['type_id']}, ${task['status_id']}, ${task['priority_id']}, \"${task['description']}\");
                ";
            
            $result = $conn->query($sql);
            $_SESSION['message'] = "Task has been added successfully !";
        }

		header('location: index.php');
    }

    function updateTask()
    {
        global $conn;

        if($task = taskFromPost()) {
            $sql = "
                    UPDATE Tasks
                    SET title=\"${task['title']}\", task_datetime=\"${task['task_datetime']}\", type_id=${task['type_id']}, priority_id=${task['priority_id']}, status_id=${task['status_id']}, description=\"${task['description']}\"
                    WHERE id = ${task['task_id']};
                ";

            $result = $conn->query($sql);

            $_SESSION['message'] = "Task has been updated successfully !";
        }
		header('location: index.php');
    }

    function deleteTask()
    {
        global $conn;

        $task_id = $_POST["task-id"];

        $sql = "
                DELETE FROM Tasks
                WHERE id = $task_id;
               ";

        $result = $conn->query($sql);
        
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
    }
?>