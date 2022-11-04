<?php
	include("scripts.php");
	getTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>YouCode | Scrum Board</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />

	<!-- ================== BEGIN core-css ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="assets/css/vendor.min.css" rel="stylesheet" />
	<link href="assets/css/default/app.min.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
	<!-- BEGIN #app -->
	<div id="app" class="app-without-sidebar">
		<!-- BEGIN #content -->
		<div id="content" class="app-content main-style">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-auto" aria-level="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Scrum Board </li>
						</ol>
						<!-- BEGIN page-header -->
						<h1 class="fs-4">
							Scrum Board
						</h1>
					</div>
					<!-- END page-header -->
					<div class="col-auto align-self-center">
						<button type="button" id="add-task-button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-task"><i class="bi bi-plus"></i> Add Task</button>
					</div>
				</div>
				<div class="container gx-0 py-2">
					<?php if (isset($_SESSION['message'])): ?>
						<div class="alert alert-green alert-dismissible fade show">
						<strong>Success!</strong>
							<?php 
								echo $_SESSION['message']; 
								unset($_SESSION['message']);
							?>
							<button type="button" class="btn-close" data-bs-dismiss="alert"></span>
						</div>
					<?php endif ?>
					<?php if (isset($_SESSION['error'])): ?>
						<div class="alert alert-danger alert-dismissible fade show">
						<strong>Fail!</strong>
							<?php 
								echo $_SESSION['error']; 
								unset($_SESSION['error']);
							?>
							<button type="button" class="btn-close" data-bs-dismiss="alert"></span>
						</div>
					<?php endif ?>
					<div class="row g-3">
						<div class="col-lg-4">
							<div class="">
								<div class="bg-black rounded-top text-white p-2">
									<h4 class="text-start fs-6 my-0">To do (<span id="todo-tasks-count"><?php echo $tasks_counters["To Do"];?></span>)</h4>
								</div>
								<div class="min-vh-100" id="to-do-tasks">
									<!-- TO DO TASKS HERE -->
									<?php
										addTasks("To Do");
									?>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="">
								<div class="bg-black rounded-top text-white p-2">
									<h4 class="text-start fs-6 my-0">In Progress (<span id="in-progress-tasks-count"><?php echo $tasks_counters["In Progress"];?></span>)</h4>
								</div>
								<div class="min-vh-100" id="in-progress-tasks">
									<!-- IN PROGRESS TASKS HERE -->
									<?php
										addTasks("In Progress");
									?>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="">
								<div class="bg-black rounded-top text-white p-2">
									<h4 class="text-start fs-6 my-0">Done (<span id="done-tasks-count"><?php echo $tasks_counters["Done"];?></span>)</h4>
								</div>
								<div class="min-vh-100" id="done-tasks">
									<!-- DONE TASKS HERE -->
									<?php
										addTasks("Done");
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #content -->

			<!-- BEGIN scroll-top-btn -->
			<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
				data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
			<!-- END scroll-top-btn -->
		</div>
		<!-- END #app -->

		<!-- TASK MODAL -->
		<form class="modal fade" method="POST" action="scripts.php" id="modal-task" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="modal-header-title">Add Task</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body fs-11px">
						<input type="text" id="add-task-id" name="task-id" hidden>
						<div class="mb-3">
							<label for="title-of-task" class="form-label">Title</label>
							<input type="text" name="task-title" class="form-control" id="title-of-task" required>
						</div>
						<label for="task-type" class="form-label">Type</label>
						<div class="form-check mx-3">
							<input type="radio" name="task-type" value="Feature" class="form-check-input" id="feature-radio" checked>
							<label class="form-check-label" for="feature-radio">Feature</label>
						</div>
						<div class="form-check mx-3">
							<input type="radio" name="task-type" value="Bug" class="form-check-input" id="bug-radio">
							<label class="form-check-label" for="bug-radio">Bug</label>
						</div>
						<div class="mt-2">
							<label for="priority-select" class="form-label">Priority</label>
							<select id="add-task-priority" name="task-priority" class="form-select" aria-label="priority-select" required>
								<option selected value="">Please select</option>
								<option value="Critical">Critical</option>
								<option value="High">High</option>
								<option value="Medium">Medium</option>
								<option value="Low">Low</option>
							</select>
						</div>
						<div class="mt-2">
							<label for="status-select" class="form-label">Status</label>
							<select id="add-task-status" name="task-status" class="form-select" aria-label="status-select" required>
								<option value="">Please select</option>
								<option value="To Do">To Do</option>
								<option value="In Progress">In Progress</option>
								<option value="Done">Done</option>
							</select>
						</div>
						<div class="mt-2">
							<label for="add-task-date" class="form-label">Date</label>
							<input type="date" name="task-date" class="form-control" id="add-task-date" required>
						</div>
						<div class="mt-2">
							<label for="add-task-description" class="form-label">Description</label>
							<textarea class="form-control" name="task-description" id="add-task-description" rows="5" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" id="add-task-close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" name="delete" id="add-task-delete" class="btn btn-danger">Delete</button>
						<button type="submit" name="update" id="add-task-update" class="btn btn-success">Update</button>
						<button type="submit" name="save" id="add-task-save-changes" class="btn btn-primary">Save</button>
					</div>
				</div>
			</div>
		</form>
		<!-- ================== BEGIN core-js ================== -->
		<script src="assets/js/vendor.min.js"></script>
		<script src="assets/js/app.min.js"></script>
		<!-- ================== END core-js ================== -->
		<script src="scripts.js"></script>
</body>
</html>