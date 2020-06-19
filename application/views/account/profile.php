<div class="container">
	<h1 class="mt-4 mb-3"><?php echo $title ?></h1>
    <div class="row">
        <div class="col-lg-8 mb-4">
            <form action="/account/profile" method="post">
                <div class="control-group form-group">
                    <div class="controls">
						<label>Имя профиля</label>
						<input class="form-control" type="text" name="login" disabled value="<?php echo $_SESSION['account']['login']; ?>">
						<input class="form-control" type="hidden" name="message" value="<?php echo $_SESSION['account']['new_message']; ?>">
                    </div>
				</div>
				<button type="submit" class="btn btn-primary">
					Новых сообщений <span class="badge badge-light"><?php echo $_SESSION['account']['new_message']; ?></span>
				</button>
            </form>
        </div>
    </div>
</div>