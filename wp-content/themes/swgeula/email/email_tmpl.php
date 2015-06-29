<html>
	<head>

		<meta charset="UTF-8">	
		
		<title><?php if (isset($email_subject)) echo $email_subject;?></title>
	
	</head>
	<body style="margin:0; padding:0; font-family: Arial; background-color:#ebebeb;" align="center">
		<center>
		<div id="email_container" style="background:#39add1;width:100%; height:300px; text-align:center;"><div style="padding-top:60px; color:#fff; font-size:38px;">גאולה VOD</div></div>
		
		<div style="background:#ffffff; min-height:400px;width:1100px;margin-right:auto; margin-left:auto; margin-top:-140px; text-align:center; padding-top:10px;  box-shadow: 3px 3px 5px #888888;" align="center"  id="email_header">
		<table width="1100" align="center"><tr><td align="center">
				<h1 style="padding:5px 0 0 0; color:#555459; font-weight: normal;">
					<?php if (isset($email_subject)) echo $email_subject;?>
				</h1>
				<h3 style="padding:5px 0 0 0; color:#555459; font-weight: normal; padding-top:0px;">
					<?php //echo $email_subject;?>
				</h3>
			</td></tr>
			<tr><td align="center">			
				<div style="border-bottom: 1px solid #555459; padding-top:20px; width: 300px; margin-left:auto; margin-right:auto;" align="center" width="300"></div>
			</td></tr>				
			<tr><td align="center">			
				<div style="color:#555459; padding-top:40px;" <?php if (isset($sLang) && ($sLang=="he")) {?>dir="rtl"<?php }?>><?php if (isset($email_body)) echo $email_body;?></div>
			</td></tr>	
		</table>
		</div>				
		
		<div style="color:#39add1; width:1100px; margin-right:auto; margin-left:auto; text-align:right; padding-top:20px; padding-right:20px;" align="center">
		<table width="1100" align="center"><tr><td <?php if (isset($sLang) && ($sLang=="he")) {?>align="right"<?php }?> <?php if (isset($sLang) && ($sLang=="he")) {?>dir="rtl"<?php }?> >
			<?php if (isset($email_disclaimer)) echo $email_disclaimer;?>
			</td></tr>			
		</table>
		</div>							
	</center>
	</body>
</html>