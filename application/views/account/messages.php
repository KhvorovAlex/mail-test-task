<div class="container">
	<h1 class="mt-4 mb-3"><?php echo $title ?></h1>
    <div class="row">
        <div class="col-lg-8 mb-4">
			<?php foreach ($data as $key): ?>
				<form action="/account/messages/" method="post">
					<div class="row">
						<div class="col-2"><?php echo $key['message_number']; ?></div>
						<div class="col-6"><?php echo $key['message_body']; ?></div>
						<?php if ($key['message_status']): ?>
							<div class="col-4 mb-5">
								<a href="/account/message/<?php echo $key['message_number']; ?>" class="btn btn-primary">Прочитать</a>
							</div>
						<?php else: ?>
							<div class="col-4 mb-5">
								<a href="/account/message/<?php echo $key['message_number']; ?>" class="btn btn-secondary">Прочитано</a>
							</div>
						<?php endif; ?>
					</div>
				</form>
			<?php endforeach; ?>
        </div>
    </div>
</div>