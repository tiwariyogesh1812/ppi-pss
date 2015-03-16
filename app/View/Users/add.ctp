<html>
<title></title>
<head>
<!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type='javascript' text='javascript/html'>
$('.creload').on('click', function() {
	alert('m here');
    var mySrc = $(this).prev().attr('src');
    var glue = '?';
    if(mySrc.indexOf('?')!=-1)  {
        glue = '&';
    }
    $(this).prev().attr('src', mySrc + glue + new Date().getTime());
    return false;
});
</script> -->

<!-- app/View/Users/add.ctp -->
<style>
.creload{margin-left:5px;}
</style>
</head>
<body>
<div class="users form">
 
<?php echo $this->Form->create('User');?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php 
        echo $this->Form->input('firstname',array('label'=>'First Name'));
        echo $this->Form->input('lastname',array('label'=>'Last Name'));
        echo $this->Form->input('username',array('label'=>'Email Id'));
        echo $this->Form->input('email_confirm',array('label'=>'Confirm Email Id'));
        echo $this->Form->input('password');
        echo $this->Form->input('password_confirm', array('label' => 'Confirm Password', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password'));
        
        /*
        if($loggeduser == 'yogesh.tiwari@aptaracorp.com') {
          echo $this->Form->input('role', array(
            'options' => array('submiter' => 'Submiter', 'submiter-manager' => 'Submiter-Manager', 'content-manager' => 'Content-Manager', 'reviewer' => 'Reviewer')
        ));
        }else {
         */
        $this->Captcha->render(array('type'=>'image'));
        // }
        echo $this->Form->submit('Add User', array('class' => 'form-submit',  'title' => 'Click here to add the user') ); 
?>
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>
<?php 
if($this->Session->check('Auth.User')){
echo $this->Html->link( "Return to Dashboard",   array('action'=>'index') ); 
echo "<br>";
echo $this->Html->link( "Logout",   array('action'=>'logout') ); 
}else{
echo $this->Html->link( "Return to Login Screen",   array('action'=>'login') ); 
}
?>
</body>
</html>