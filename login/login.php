<?
           session_start();
?>
<meta charset="euc-kr">
		<?

			$id=$_POST[id];
			$pass=$_POST[pass];
		   // 이전화면에서 이름이 입력되지 않았으면 "이름을 입력하세요"
		   // 메시지 출력
		   if(!$id) {
			 echo("
				   <script>
					 window.alert('아이디를 입력하세요.')
					 history.go(-1)
				   </script>
				 ");
				 exit;
		   }

		   if(!$pass) {
			 echo("
				   <script>
					 window.alert('비밀번호를 입력하세요.')
					 history.go(-1)
				   </script>
				 ");
				 exit;
		   }

		   include "../lib/dbconn.php";

		   $sql = "select * from member where id='$id'";
		   $result = mysql_query($sql, $connect);

		   $num_match = mysql_num_rows($result);

		   if(!$num_match) 
		   {
			 echo("
				   <script>
					 window.alert('등록되지 않은 아이디입니다.')
					 history.go(-1)
				   </script>
				 ");
			}
			else
			{
				$row = mysql_fetch_array($result);

				$db_pass = $row[pass];
				// 넘겨받은 pass랑 db에서 찾은 비밀번호랑 같은지 비교한다.
				if($pass != $db_pass)
				{
				   echo("
					  <script>
						window.alert('비밀번호가 틀립니다.')
						history.go(-1)
					  </script>
				   ");

				   exit;
				}
				else if($row[level] > 8)
				{//level이 9이상이므로 인증이 안된상태
					echo("
						<script>
							window.alert('인증되지 않은 계정입니다.')
							history.go(-1)
						</script>
						");
				}
				else
				{
				   $userid = $row[id];
				   $username = $row[name];
				   $usernick = $row[nick];
				   $userlevel = $row[level];

				   $_SESSION['userid'] = $userid;
				   $_SESSION['username'] = $username;
				   $_SESSION['usernick'] = $usernick;
				   $_SESSION['userlevel'] = $userlevel;
				 $_SESSION['timeout'] = time();
				   echo("
					  <script>
						location.href = '../index.php';
					  </script>
				   ");
				   //echo "<script>history.go(-2);</script>";
				}
		   }          
		?>
