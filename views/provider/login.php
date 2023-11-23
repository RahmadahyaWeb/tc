<?php 

	use yii\helpers\Url;

?>

<div class="row min-vh-100 justify-content-center align-items-center">
	<div class="col-md-5">
		<h1 class="text-end text-white" style="font-size: 3rem;">MY TRICARE</h1>
		<div class="login rounded-0">
			<div>
				<form action="<?= Url::to(['provider/login'])  ?>" method="post">
					<div class="d-flex flex-column gap-3 p-4">
						<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
						<div class="row align-items-center">
						  <div class="col-lg-3">
						    <label for="username" class="col-form-label">Username</label>
						  </div>
						  <div class="col-lg-9">
						    <input type="text" id="username" class="form-control rounded-0 <?= (isset($errors['username'])) ? 'is-invalid' : '' ?>" name="LoginProvider[username]" placeholder="USERNAME" value=<?= isset($values['username']) ? $values['username'] : '' ?>>
						  </div>
						   <div class="col-lg-3">
						  </div>
						  <div class="col-lg-9 mt-2">
						  	<div class="text-danger">
						  		<?= isset($errors['username']) ? $errors['username'][0] : 
						  		'' ?>
						  	</div>
						  </div>
						</div>
						<div class="row align-items-center">
						  <div class="col-lg-3">
						    <label for="password" class="col-form-label">Password</label>
						  </div>
						  <div class="col-lg-9">
						    <input type="password" id="password" class="form-control rounded-0 <?= (isset($errors['password'])) ? 'is-invalid' : '' ?>" name="LoginProvider[password]" placeholder="PASSWORD"> 
						  </div>
						  <div class="col-lg-3">
						  </div>
						  <div class="col-lg-9 mt-2">
						  	<div class="text-danger">
						  		<?= isset($errors['password']) ? $errors['password'][0] : 
						  		'' ?>
						  	</div>
						  </div>
						</div>
						<div class="row align-items-center">
						  <div class="col-lg-3">
						  </div>
						  <div class="col-lg-9">
						    <button class="btn btn-dark rounded-0">LOGIN</button>
						  </div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>