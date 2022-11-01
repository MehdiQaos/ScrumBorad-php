<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="test.php">
    <label for="task-type" class="form-label">Type</label>
    <div class="form-check mx-3">
        <input type="radio" name="task-type" value="Feature" class="form-check-input" id="feature-radio">
        <label class="form-check-label" for="feature-radio">Feature</label>
    </div>
    <div class="form-check mx-3">
        <input type="radio" name="task-type" value="Bug" class="form-check-input" id="bug-radio">
        <label class="form-check-label" for="bug-radio">Bug</label>
    </div>
    <input type="submit">
    </form>

    <?php
        $tasks_priorities = array(
            "Low" => 1,
            "Medium" => 2,
            "High" => 3,
            "Critical" => 4
        );

        $tasks_statuses = array(
            "To Do" => 1,
            "In Progress" => 2,
            "Done" => 3
        );

        $tasks_types = array(
            "Feature" => 1,
            "Bug" => 2
        );

        function vd($data) {
            echo "<pre>";
            var_dump($data);
            echo "</pre>";
        }

        function piq() {
            // global $tasks_types, $tasks_priorities, $tasks_statuses;

            var_dump($_POST);

            // $title = $_POST["task-title"];
            // $type_id = $tasks_types[$_POST["task-type"]];
            // $priority_id = $tasks_priorities[$_POST["task-priority"]];
            // $status_id = $tasks_statuses[$_POST["task-status"]];
            // $task_datetime = $_POST["task-date"];
            // $description = $_POST["task-description"];

            // vd($title);
            // vd($task_datetime);
            // vd($description);
            // vd($_POST["task-type"]);
            // vd($status_id);
            // vd($type_id);
            // vd($priority_id);
        }

        piq();

        // require "database.php";

        // $sql = "SELECT * FROM Tasks JOIN Statuses ON status_id = statuses_id JOIN Types ON type_id = types_id JOIN Priorities ON priority_id = priorities_id";
        // $result = $conn->query($sql);
        // echo "<br>" . $result->num_rows;
        // $status = "Done";
        // if (isset($_POST['task-type'])) {
        //     echo "<br>" . $_POST['task-type'] . "<br>";
        // }
        // vd($tasks_priorities[$_POST["task-priority"]]);
        // vd($tasks_types[$_POST["task-type"]]);
        // vd($tasks_statuses[$_POST["task-status"]]);

        // $sql = "
        //         INSERT INTO Tasks (title, task_datetime, type_id, status_id, priority_id, description)
        //         VALUES (\"$title\", \"$task_datetime\", $type_id, $status_id, $priority_id, \"$description\");
        //        ";
        
        // $result = $conn->query($sql);
    ?>
</body>
</html>