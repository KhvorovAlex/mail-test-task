<div class="container">
    <div class="row">
		<?php if (isset($_SESSION['account']['id'])): ?>
			<div class="col-12 mt-5 text-center">
				<p class="h3">Добро пожаловать, <b><?php echo $_SESSION['account']['login']; ?></b> </p>
				<p>в приложение </p>
				<h1 class="my-4">Почта.Документооборот 1.0</h1> 
			</div>
		<?php else: ?>
			<div class="col-12 mt-5 text-center">
				<p class="h3">Добро пожаловать</p>
				<p>в приложение </p>
				<h1 class="my-4">Почта. Документооборот 1.0</h1> 
			</div>
		<?php endif; ?>
    </div>
</div>