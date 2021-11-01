<html>
<form name="page2" action="analysis.php" method="post" onsubmit="return validateForm();">
  Lines: </br> 
  <?php $s = $_POST['s']; 
    for ( $i=0; $i<$s; $i++ ){
        echo '<input type="text" name="lines['.$i.']" value=""><br/>';
    }
  ?>
  <input type="hidden" name="s" value="<?php echo $_POST['s'];?>" >
  <input type="submit" name="printOut" value="Result">
</form>
<script type="text/javascript">

function validateForm(){
	var s = document.forms["page2"]["s"].value;
	for (var i=0; i<s; i++){
		 if (document.getElementsByName('lines['+i+']')[0].value == ""){
		 	 alert('Complete all the fields');		 
		 	 return false;
		 }
	}
}

</script>

</html>