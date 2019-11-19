<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--<link rel=”Shortcut Icon” type=”image/x-icon” href=”http://www.yourdomain.com/your-favicon-image.png” />-->
		<title>{{ $emaildata['subject'] }}</title>
	</head>
	<body style="margin:0px;" style="@import url('https://fonts.googleapis.com/css?family=Montserrat|Open+Sans&display=swap')" rel="stylesheet')">
		<table border="0" width="600" cellpadding="0" cellspacing="0" align="center" bgcolor="#ff5d60" style="font-family: 'Open Sans', sans-serif;padding-top: 10px">
			<tr>
				<td width="10"></td>
				<td width="540">
					<table width="100%" border="0" align="" cellpadding="0" cellspacing="0" >
						<tr>
							<td>
								
							</td>
							
						</tr>
						<tr>
							<td  colspan="2" style="padding: 20px 0;background: #fff;border-bottom: 2px solid #969696;">
								<table width="100%;">
									<tr>
										<td width="30"></td>
										<td width="200">											
											<img align="left" src="http://org1.kloveslab.com/images/Logo.svg">
										</td>
										<td width="310"></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding: 30px 0;background-color: #fff;">
								<table width="100%;" bgcolor="#fff">
									<tr>
										<td width="30"></td>
										<td width="480">
											<p style="font-size: 16px;color: #000;">Dear {{ $emaildata['receiver_name'] }}</p>
											<p style="font-size: 14px;color: #000;line-height: 21px;">
												{!!  $emaildata['message'] !!}
											</p>
											<p style="font-size: 14px;color: #000;line-height: 21px;">Thank you<br/>
											Expertwithin  Team</p>
										</td>
										<td width="30"></td>
									</tr>
								</table>
							</td>
						</tr>
					
						<tr>
							<td colspan="2" style="padding:0 0 20px 0; text-align: center;background-color: #ff5d60; padding-top: 15px;">				
								<table width="100%;" bgcolor="#ff5d60" align="center">
									
									<tr>
										<td width="30"></td>
										<td width="480">
											<p style="color:#000;font-size: 12px;text-align: center;margin: 10px 0;">
												© 2019  Expertwithin<sup style="font-size: 8px;">TM</sup> All Rights Reserved
											</p>
										</td>
										<td width="30"></td>
									</tr>
									
								</table>																								
						</td>
					</tr>
				</table>

			</td>
			<td width="10"></td>
		</tr>
	</table>
</body>
</html>