
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header"><?php echo $title; ?></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <form action="/admin/add" method="post">
                            <div class="form-group">
								<label>Выберите пользователя</label>
								<?php if (!empty($data[0]['login'])): ?>
									<select name="user" class="mb-5" style="display: block;">
										<?php foreach ($data as $val):?>
											<option value="<?php echo $val['id'] ?>"><?php echo $val['login'] ?></option>
										<?php endforeach; ?>
									</select>
									<div class="form-group">
										<label>Текст</label>
										<textarea class="form-control" rows="3" name="message-text"></textarea>
									</div>
									<button type="submit" class="btn btn-primary btn-block">Отправить</button>
								<?php else: ?>
									<p><b>Пользователей в базе данных еще нет!</b></p>
								<?php endif; ?>
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>