<?php
	require_once ( dirname( __DIR__ , 2 ).'/resources/assets/phpexcel/PHPExcel/IOFactory.php');
	
	if(isset($_FILES['excelFile']) && !empty($_FILES['excelFile']['tmp_name'])){
		$excelObject = PHPExcel_IOFactory::load($_FILES['excelFile']['tmp_name']);
		
		foreach (range('A', $excelObject->getActiveSheet()->getHighestDataRow()) as $col) {
			$excelObject->getActiveSheet()->getStyle('A'.$col)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
        }
		
		$getSheet = $excelObject->getActiveSheet()->toArray(null);
		
		echo "<table>";
		foreach ($getSheet as $row) {
		   echo "<tr>";
		   foreach ($row as $column) {
			  echo "<td>$column</td>";
		   }
		   echo "</tr>";
		}    
		echo "</table>";
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP Excel docs reader</title>
</head>
<body>
	<form action="" method="POST" enctype="multipart/form-data">
		<input type="file" name="excelFile">
		<input type="submit" value="Submit">
	</form>
</body>
</html>