<?php 
	//过滤器函数
	/*$name= $_POST['name'];
	//检查post传递过来的数据
	if(filter_has_var(INPUT_POST,'name')){
		echo 'name值存在'.$name;
	}else{
		echo 'name值不存在';
	 } */
	
	
	//验证是否是邮箱
	/*$email= $_POST['email'];
	//1.删除邮箱中不必要字符
	$email=filter_var('email',FILTER_SANITIZE_EMAIL);
	 if(isset($email)){ 
		if(filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)){
			echo 'EMAIL存在'.$email;
		}else{
			echo '不存在';
		}
	}*/
	
	
	//首先判断是否点击发送
	$mag= '';
	$magClass= '';
	if(filter_has_var(INPUT_POST,'sumbit')){
		//1.取值，移除头尾部空字符串，判断是否为空
		$name = trim($_POST['name']);
		
		$tel = trim($_POST['tel']);
		
		$email = trim($_POST['email']);
		
		if(!empty($name) && !empty($tel) && !empty($email) ){
			//先排除邮箱中不合法的字符FILTER_SANITIZE_EMAIL
			$new_email = filter_var($email,FILTER_SANITIZE_EMAIL);
			//再验证邮箱是否合格FILTER_VALIDATE_EMAIL
			if(filter_var($new_email,FILTER_VALIDATE_EMAIL)== false){
				$mag = '邮箱不合格';
				$magClass = 'alert';
			}elseif(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$tel) == false){
				//验证电话号码
				$mag= '请输入正确的电话号码';
				$magClass ='alert';
			}else{
				$toEmail='1216616894@qq.com';
				$subject= '邮箱来自'.$name;
				$body= '<h4>姓名：'.$name.'</h4>
						<h4>电话：'.$tel.'</h4>
						<h4>邮箱：'.$new_email.'</h4>';
						
				//header
				$headers= "MIME-Version:1.0"."\r\n";
				$headers .= "Content-Type:text/html;charset=UTF-8"."\r\n";
				$headers .= "From: ".$name."<".$new_email.">\r\n";
				
				if(mail($toEmail,$subject,$body,$headers)){
					$mag= '邮件发送成功，请注意查收';
					$magClass ='alert';
				}else{
					$mag= '邮件发送失败';
					$magClass ='alert';
				}
			}
		}else{
			
			$mag= '内容不能为空';
			
			$magClass ='alert';
		}
	}
	
	
?>
<html>
<head>
<meta charset="UTF-8"/>
<title>过滤器函数</title>
<style>
.alert{
	background:#3bbdd2;
	width:150px;
	height: 30px;
	line-height: 30px;
	color: #fff;
	text-align: center;
}
	
</style>
</head>

<body>
	
	<?php if($mag != ''):?>
		<div class="<?php echo $magClass ?>">
			<?php echo $mag?>
		</div>
	<?php endif;?>

	
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
	
		<label>姓名</label>
		<input type="text" name="name" value="<?php echo isset($name)?$name:'' ?>"/>
		
		<label>电话</label>
		<input type="text" name="tel" value="<?php echo isset($tel)?$tel:'' ?>"/>
		
		<label>邮箱</label>
		<input type="text" name="email" value="<?php echo isset($new_email)?$new_email:'' ?>"/> 
		
		<button type="sumbit" name="sumbit"> 确认</button>
	
	</form>
</body>

</html>