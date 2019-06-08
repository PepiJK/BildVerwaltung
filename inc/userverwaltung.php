<?php

if ($_GET['url'] == 'userverwaltung') { 

	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$action = $_POST['action'];
		switch($action) {
			case 'deleteUser': 
				$db->deleteUser($_POST['name']);
				break;

			case 'emailPasswordReset':
				// create 16 character random password containing number 0-9 and letters a-f
				$bytes = openssl_random_pseudo_bytes(8);
				$pseudoPwd = bin2hex($bytes);
				$newPwd = password_hash($pseudoPwd, PASSWORD_DEFAULT);
			
				$db->changeUserPassword($_POST['name'], $newPwd, false);

				// send generated password via email
				$to = $_POST['email'];
				$subject = "Neues Passwort";
				$messages = "Neues Passwort: " . $pseudoPwd;
				mail($to, $subject, $messages);
				break;

			case 'statusChange':
				if($_POST['status']){
					$status = 0;
				} else {
					$status = 1;
				}
				$db->changeStatus($status, $_POST['name']);
				break;
		}
	}
	
	$users = $db->getAllUsers();
	$i = 1;
	?>

<main>
	<div class="container mt-3">
		<h1>Userverwaltung</h1>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Username</th>
					<th scope="col">Vorname</th>
					<th scope="col">Nachname</th>
					<th scope="col">E-Mail</th>
					<th scope="col">Status</th>
					<th scope="col">Option</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $nutzer) { ?>
				<tr>
					<th scope="row"><?php echo $i ?></th>
					<td><?php echo $nutzer->username ?></td>
					<td><?php echo $nutzer->vorname ?></td>
					<td><?php echo $nutzer->nachname ?></td>
					<td><?php echo $nutzer->email ?></td>
					<td id="status"><?php if($nutzer->status){ ?>
						<i class="fas fa-thumbs-up text-success" onclick="changeStatus(<?php echo $nutzer->status ?>, '<?php echo $nutzer->username ?>', this)"></i>
						<?php }else { ?>
						<i class="fas fa-thumbs-down text-danger" onclick="changeStatus(<?php echo $nutzer->status ?>, '<?php echo $nutzer->username ?>', this)"></i>
						<?php } ?>
					</td>
					<td>
						<i class="fas fa-envelope text-warning mr-2" onclick="emailPasswordReset('<?php echo $nutzer->email ?>', '<?php echo $nutzer->username ?>')"></i>
						<i class="fas fa-trash-alt text-danger" onclick="deleteUser('<?php echo $nutzer->username ?>', this)"></i>
					</td>
				</tr>
				<?php $i++; } ?>
			</tbody>
		</table>
	</div>
</main>

<?php }
