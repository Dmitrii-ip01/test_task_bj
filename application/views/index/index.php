
<div class="container main_block">
	<div class="row">
		<div class="col">
			<h2 class="text-primary">Создание задачи</h2>
		</div>
	</div>
</div>
<section>
	<div class="container">
		<div class="row  justify-content-center">
			<div class="col-lg-6 wrap-form">
				<!-- Notification -->
          <?php if (isset($data['errors'])): ?><?php foreach ($data['errors'] as $error): ?>
						<div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
						</div>
          <?php endforeach; ?><?php endif; ?>
          <?php if (isset($data['success']) && $data['success']): ?>
						<div class="alert alert-success show hide" id="alert" role="alert">
							<strong>Отлично! </strong>Ваша задача успешно добавлена.
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
          <?php endif; ?>
				<form action="<?php echo $data['action']; ?>" method="post">
					<div class="form-group">
						<label>Имя</label>
						<input type="text" class="form-control" placeholder="-" name="name">
						<small type="text" class="form-text text-muted"></small>
					</div>
					<div class="form-group">
						<label>Задача</label>
						<input type="text" class="form-control" placeholder="-" name="task">
					</div>
					<div class="form-group">
						<label for="">E-mail</label>
						<input type="text" class="form-control" placeholder="-" name="email">
					</div>
					<input type="submit" name="submit" class="btn btn-primary" value="Добавить"/>
				</form>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="container">
		<div class="wrap-dropdown row">
			<div class="col-lg-10 text-center">
				<div class="row justify-content-between">
					<div class="col-sm-4">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Имя
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<button class="dropdown-item" onclick="sortTasks('name','asc')">По алфавиту</button>
								<button class="dropdown-item" onclick="sortTasks('name','desc')">В обратном порядке</button>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Email
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<button class="dropdown-item" onclick="sortTasks('email','asc')">По алфавиту</button>
								<button class="dropdown-item" onclick="sortTasks('email','desc')">В обратном порядке</button>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Статус
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

								<button class="dropdown-item" onclick="sortTasks('status','asc')">Сначала невыполненные</button>
								<button class="dropdown-item" onclick="sortTasks('status','desc')">Сначала выполненные</button>
							</div>
						</div>
					</div>
				</div>
				<table class="table table-hover ">
					<thead class="thead bg-primary">
					<tr>
						<th scope="col">Имя</th>
						<th scope="col">Задача</th>
						<th scope="col">E-mail</th>
						<th scope="col">Статус</th>
					</tr>
					</thead>
					<tbody>
          <?php foreach ($data['tasks'] as $task => $value): ?>
						<tr>
							<td><?php echo $value['name'] ?></td>
							<td>
                  <?php echo $value['task'] ?>
								<?php if (isset($data['admin']) && $data['admin']): ?>
									<button type="button" class="btn btn-warning btn-admin"  data-toggle="modal" data-target="#ModalTaskEdit"  data-id="<?php echo $value['id'] ?>" data-task="<?php echo $value['task'] ?>"></button>
								<?php endif; ?>
                  <?php if ($value['edit']): ?>
										<small>*отредактировано администратором</small>
                  <?php endif; ?>
							</td>
							<td><?php echo $value['email'] ?></td>
							<td>
                  <?php if (isset($data['admin']) && $data['admin']): ?><?php if ($value['status']): ?>
										<button type="button" class="btn btn-success status" data-toggle="button" data-id="<?php echo $value['id'] ?>" aria-pressed="<?php echo $value['status'] ? 'true' : 'false'; ?>" autocomplete="off">
                        <?php echo $value['status'] ? 'выполнено' : 'не выполнено'; ?>
										</button>
                  <?php else: ?>
										<button type="button" class="btn btn-danger status" data-toggle="button" data-id="<?php echo $value['id'] ?>" aria-pressed="<?php echo $value['status'] ? 'true' : 'false'; ?>" autocomplete="off">
                        <?php echo $value['status'] ? 'выполнено' : 'не выполнено'; ?>
										</button>
                  <?php endif; ?><?php else: ?><?php if ($value['status']): ?>
										<button type="button" class="btn btn-success status" data-toggle="button" data-id="<?php echo $value['id'] ?>" disabled aria-pressed="<?php echo $value['status'] ? 'true' : 'false'; ?>" autocomplete="off">
                        <?php echo $value['status'] ? 'выполнено' : 'не выполнено'; ?>
										</button>
                  <?php else: ?>
										<button type="button" class="btn btn-danger status" data-toggle="button" data-id="<?php echo $value['id'] ?>" disabled aria-pressed="<?php echo $value['status'] ? 'true' : 'false'; ?>" autocomplete="off">
                        <?php echo $value['status'] ? 'выполнено' : 'не выполнено'; ?>
										</button>
                  <?php endif; ?><?php endif; ?>
							</td>
						</tr>
          <?php endforeach; ?>
					</tbody>
				</table>
				<div class="btn-toolbar justify-content-center" role="toolbar" aria-label="Toolbar with button groups">

					<div class="btn-group" role="group" aria-label="First group">
              <?php foreach ($data['page'] as $page => $value): ?>
								<button type="button" onclick="window.location ='<?php echo $value['link'] ?>'" class="btn btn-primary <?php if ($data['active_link'] == $value['num']) {
                    echo 'active';
                } ?>"><?php echo $value['num']; ?>
								</button>
              <?php endforeach; ?>

					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="ModalTaskEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Редактирование задачи</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<input type="hidden" class="form-control" id="id">
								<label for="task" class="col-form-label">Текст:</label>
								<input type="text" class="form-control" id="task">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
						<button type="button" id="updateTask" class="btn btn-primary">Сохранить</button>
					</div>
				</div>
			</div>
		</div>
</section>
<script src="./application/views/js/common.js">
</script>

</script>
</body>
</html>
