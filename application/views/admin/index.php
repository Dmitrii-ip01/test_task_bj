</header>

<div class="container main_block">
	<div class="row">
		<div class="col">
		<h2>Введите ваши данные</h2>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col">
        <?php if (isset($data['errors'])): ?><?php foreach ($data['errors'] as $error): ?>
					<div class="alert alert-danger" role="alert">
              <?php echo $error; ?>
					</div>
        <?php endforeach; ?>
        <?php endif; ?>

			<form action="" method="post" class="signup-form">
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-2 col-form-label">Имя</label>
					<div class="col-sm-10">
						<input type="text" name="name" class="form-control" id="inputEmail3" placeholder="-" value="<?php if (isset($data['name'])) echo $data['name']?>">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword3" class="col-sm-2 col-form-label">Пароль</label>
					<div class="col-sm-10">
						<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="-">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-10">
						<input type="submit" name="submit" class="btn btn-primary" value="Вход"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col">
			<ul class="list-group list-group-flush">
				<li class="list-group-item">
					<a href="/" class="text-danger">Вернуться на сайт</a>
				</li>
			</ul>
		</div>
	</div>
</div>
</body>
</html>
