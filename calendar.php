<?php
	require_once('connect.php');

	// Проверка авторизации
	session_start();
	if (!isset($_SESSION['user_id'])) {
		// Если пользователь не авторизован, перенаправляем на страницу входа
		header("Location: index.php");
		exit();
	}
	// Получение идентификатора текущего пользователя из сессии
	$user_id = $_SESSION['user_id'];

	// Запрос на получение событий текущего пользователя
	$sql = "SELECT id, title, start, end, color FROM events WHERE user_id = :user_id";
	$req = $bdd->prepare($sql);
	$req->execute(array('user_id' => $user_id));
	$events = $req->fetchAll();
?>


	<!DOCTYPE html>
	<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Full calendar PHP</title>
	
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css"/>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
		<script src="https://code.jquery.com/jquery.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
		
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/ru.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		


		<!-- Custom CSS -->
		<style>
  body {
            background-color: #f8f9fa;
            /* изменение цвета фона */
            font-family: Arial, sans-serif;
            /* изменение шрифта */
        }

        h1 {
            color: #007bff;
            /* изменение цвета заголовка */
            margin-top: 30px;
            /* увеличение отступа сверху */
        }

        p {
            color: #6c757d;
            /* изменение цвета текста */
        }

        .col-centered {
            margin: 0 auto;
            /* выравнивание по центру */
            float: none;
            /* отмена выравнивания по умолчанию */
        }

        .btn-logout {
            background-color: #dc3545;
            /* изменение цвета фона кнопки */
            border-color: #dc3545;
            /* изменение цвета границы кнопки */
            color: #fff;
            /* изменение цвета текста кнопки */
        }

        .btn-logout:hover {
            background-color: #c82333;
            /* изменение цвета фона кнопки при наведении */
            border-color: #bd2130;
            /* изменение цвета границы кнопки при наведении */
        }

        .user-info {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .logout-container {
            margin-top: 20px;
        }
		</style>

	</head>

	<body>

	

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-right logout-container">
                <a href="logout.php" class="btn btn-logout">Выход</a> <!-- Изменение стилей кнопки выхода -->
            </div>
        </div><br>

        <div class="row">
            <div class="col-lg-12 text-center">
                <div id="calendar" class="col-centered">
            </div>
        </div>
		
		
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Добавить событие</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form class="form-horizontal" method="POST" action="addEvent.php">
					<div class="modal-body">
						<div class="form-group row">
							<label for="title" class="col-sm-3 control-label">Название:</label>
							<div class="col-sm-9">
								<input type="text" name="title" class="form-control" id="title" placeholder="Название">
							</div>
						</div>
						<div class="form-group row">
							<label for="color" class="col-sm-3 control-label">Цвет:</label>
							<div class="col-sm-9">
								<select name="color" class="form-control" id="color">
									<option value="">Выбрать</option>
									<option style="color:#0071c5;" value="#0071c5">&#9724; Темно-синий</option>
									<option style="color:#40E0D0;" value="#40E0D0">&#9724; Бирюзовый</option>
									<option style="color:#008000;" value="#008000">&#9724; Зеленый</option>
									<option style="color:#FFD700;" value="#FFD700">&#9724; Желтый</option>
									<option style="color:#FF8C00;" value="#FF8C00">&#9724; Оранжевый</option>
									<option style="color:#FF0000;" value="#FF0000">&#9724; Красный</option>
									<option style="color:#000;" value="#000">&#9724; Черный</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="start" class="col-sm-3 control-label">Дата начала:</label>
							<div class="col-sm-9">
								<input type="text" name="start" class="form-control" id="start" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="end" class="col-sm-3 control-label">Дата окончания:</label>
							<div class="col-sm-9">
								<input type="text" name="end" class="form-control" id="end" readonly>
							</div>
						</div>
						<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
						<button type="submit" class="btn btn-primary">Сохранить изменения</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form class="form-horizontal" method="POST" action="editEventTitle.php">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Редактировать событие</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="form-group">
							<label for="title" class="col-sm-2 control-label">Название</label>
							<div class="col-sm-10">
								<input type="text" name="title" class="form-control" id="title" placeholder="Название">
							</div>
						</div>
						<div class="form-group">
							<label for="color" class="col-sm-2 control-label">Цвет</label>
							<div class="col-sm-10">
								<select name="color" class="form-control" id="color">
									<option value="">Выбрать</option>
									<option style="color:#0071c5;" value="#0071c5">&#9724; Темно-синий</option>
									<option style="color:#40E0D0;" value="#40E0D0">&#9724; Бирюзовый</option>
									<option style="color:#008000;" value="#008000">&#9724; Зеленый</option>
									<option style="color:#FFD700;" value="#FFD700">&#9724; Желтый</option>
									<option style="color:#FF8C00;" value="#FF8C00">&#9724; Оранжевый</option>
									<option style="color:#FF0000;" value="#FF0000">&#9724; Красный</option>
									<option style="color:#000;" value="#000">&#9724; Черный</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<div class="checkbox">
									<label class="text-danger">
										<input type="checkbox" name="delete"> Удалить событие</label>
								</div>
							</div>
						</div>

						<input type="hidden" name="id" class="form-control" id="id">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
						<button type="submit" class="btn btn-primary">Сохранить изменения</button>
					</div>
				</form>
			</div>
		</div>
	</div>

    </div>

		<?php 
			date_default_timezone_set("Europe/Moscow");
			$date = date("Y-m-d");
		?>

		<script>
	
			$(document).ready(function () {
			const calendar = $('#calendar');
			const ModalAdd = $('#ModalAdd');
			const ModalEdit = $('#ModalEdit');
			const eventUrl = 'editEventDate.php';

			const dateFormat = 'YYYY-MM-DD HH:mm:ss';

			calendar.fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listMonth'
				},
				navLinks: true,
				editable: true,
				eventLimit: true,
				selectable: true,
				selectHelper: true,
				select: function (start, end) {
					ModalAdd.find('#start').val(start.format(dateFormat));
					ModalAdd.find('#end').val(end.format(dateFormat));
					ModalAdd.modal('show');
				},
				eventRender: function (event, element) {
					element.bind('dblclick', function () {
						ModalEdit.find('#id').val(event.id);
						ModalEdit.find('#title').val(event.title);
						ModalEdit.find('#color').val(event.color);
						ModalEdit.modal('show');
					});
				},
				eventDrop: handleEventDropResize,
				eventResize: handleEventDropResize,
				events: <?php echo json_encode($events); ?>
			});

			function handleEventDropResize(event) {
				const start = event.start.format(dateFormat);
				const end = event.end ? event.end.format(dateFormat) : start;
				const id = event.id;
				const title = event.title;
				const color = event.color;

				const eventData = { id, start, end, title, color };

				$.ajax({
					url: 'editEventDate.php',
					type: 'POST',
					data: { eventData },
					success: function (response) {
						if (response === 'OK') {
							alert('Сохранено');
						} else {
							alert('Не удалось сохранить. Попробуйте снова.');
						}
					},
					error: function () {
						alert('Произошла ошибка при отправке запроса на сервер.');
					}
				});
			}
		});


		</script>

	</body>

	</html>