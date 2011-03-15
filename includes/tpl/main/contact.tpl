<div class="post">
	<h2 class="title"><a href="#">Contact Form</a></h2>
	<form name="myContact" method="POST">
	<table style="width:100%; background-color:#f9fcfd; border:1px solid #CCCCCC; padding:10px; font-size:12px;" class="contactForm">
		<tr>
			<td style="width:25%; text-align:left; vertical-align:top; padding:5px; font-weight:bold; ">Name</td>
			<td style="text-align:left; vertical-align:top; padding:5px;"><input type="text" name="name" value="" /></td>
		</tr>
		<tr>
			<td style="width:25%; text-align:left; vertical-align:top; padding:5px; font-weight:bold; ">Email</td>
			<td style="text-align:left; vertical-align:top; padding:5px;"><input type="text" name="email" value="" /> </td>
		</tr>
		<tr>
			<td style="width:25%; text-align:left; vertical-align:top; padding:5px; font-weight:bold; ">Subject</td>
			<td style="text-align:left; vertical-align:top; padding:5px;"><input type="text" name="subject" value="" /></td>
		</tr>
		<tr>
			<td style="width:25%; text-align:left; vertical-align:top; padding:5px; font-weight:bold; ">Message</td>
			<td style="text-align:left; vertical-align:top; padding:5px;"><textarea name="message" cols="40" rows="6"></textarea></td>
		</tr>
		<tr>
			<td style="width:25%; text-align:left; vertical-align:top; padding:5px; font-weight:bold; ">Captcha</td>
			<td style="text-align:left; vertical-align:top; padding:5px;">
				<?=$DMS->myCaptcha($_POST);?> 
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:left; vertical-align:middle; padding:5px; font-size:90%; font-weight:bold;">All fields are required.</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:left; vertical-align:middle; padding:5px;">
				<input type="button" onclick="javascript:contactForm();" value="Go!"/>
			</td>
		</tr>
	</table>
	</form>
</div>
