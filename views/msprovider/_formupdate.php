<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MsProvider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-provider-form">

 <?php $form = ActiveForm::begin(); ?>

 <div class="row">
    <div class="col-sm-12">
      <?= $form->field($model, 'jenis_provider')->dropDownList(
         $listJenisProvider,
         ['prompt'=>'-- Pilih Data --']
      ); 
      ?>
   </div>

   <div class="col-sm-12">
    <?= $form->field($model, 'id_provider')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan ID Provider di sini (TRC-001-RSSI)']) ?>
 </div>

 <div class="col-sm-12">
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
 </div>

 <div class="col-sm-12">
    <?= $form->field($model, 'kab_kota')->textInput(['maxlength' => true]) ?>
 </div>

 <div class="col-sm-12">
    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
 </div>

 <div class="col-sm-12">
    <?= $form->field($model, 'no_telp')->textInput(['maxlength' => true]) ?>
 </div>

 <div class="col-sm-12">
    <?= $form->field($model, 'web')->textInput(['maxlength' => true]) ?>
 </div>

 <?php if (isset($cek_akun)): ?>
    <?php if ($cek_akun < 1): ?>
      <div class="col-sm-12">
        <h1>Akun Provider</h1>
        <hr style="border: none; border-top: 2px solid black;">
     </div>

     <div class="col-sm-6">
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" class="form-control" id="username">
       </div>
    </div>

    <div class="col-sm-6">
     <div class="form-group">
       <label>Password</label>
       <input type="password" name="password" class="form-control" id="password">
    </div>
 </div>
<?php endif ?>
<?php endif ?>

</div>

<div class="form-group">
 <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>


<?php  
$script = <<< JS
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');

usernameInput.addEventListener('change', function() {
  if (usernameInput.value.trim() !== '') {
    passwordInput.setAttribute('required', 'true');
 } else {
    passwordInput.removeAttribute('required');
 }
 if (usernameInput.value.length < 5) {
      // Jika panjang password kurang dari 5 karakter, tampilkan pesan kesalahan
    usernameInput.setCustomValidity('Username harus memiliki setidaknya 5 karakter.');
 } else {
      // Jika panjang password memenuhi syarat, hapus pesan kesalahan
    usernameInput.setCustomValidity('');
 }
});

passwordInput.addEventListener('change', function() {
  if (passwordInput.hasAttribute('required')) {
    if (passwordInput.value.length < 5) {
      // Jika panjang password kurang dari 5 karakter, tampilkan pesan kesalahan
      passwordInput.setCustomValidity('Password harus memiliki setidaknya 5 karakter.');
   } else {
      // Jika panjang password memenuhi syarat, hapus pesan kesalahan
      passwordInput.setCustomValidity('');
   }
}

if (passwordInput.value.trim() !== '') {
 usernameInput.setAttribute('required', 'true');
} else {
 usernameInput.removeAttribute('required');
}
});


JS;

$this->registerJs($script);

?>
