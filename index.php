<?php include("header.php"); ?>
<?php
	switch ($_GET['page']) {
		case 'home':
			require_once('home.php');
		break;
		
		case 'maintain_froms':
			require_once('maintain_froms.php');
		break;
		
		case 'maintain_ltem_results':
			require_once('maintain_ltem_results.php');
		break;
		
		case 'mfr_print':
			require_once('mfr_print.php');
		break;
		
		case 'projects':
			require_once('projects.php');
		break;
		
		case 'projects_view':
			require_once('projects_view.php');
		break;
		
		case 'projects_edit':
			require_once('projects_edit.php');
		break;
		
		case 'maintain_item_set':
			require_once('maintain_item_set.php');
		break;
		
		case 'projects_add':
			require_once('projects_add.php');
		break;
		
		case 'emergency_details':
			require_once('emergency_details.php');
		break;
		case 'emergency_remark':
			require_once('emergency_remark.php');
		break;
		case 'emergency_details_view':
			require_once('emergency_details_view.php');
		break;
		
		case 'ed_print':
			require_once('ed_print.php');
		break;
		
		case 'erm_print':
			require_once('erm_print.php');
		break;
		
		case 'photo_report_view':
			require_once('photo_report_view.php');
		break;
		
		case 'ed_pdf':
			require_once('ed_pdf.php');
		break;

		case 'pdf_erm':
			require_once('pdf_erm.php');
		break;

		
		case 'maintain_remark':
			require_once('maintain_remark.php');
		break;
		case 'maintain_remark_doc':
			require_once('maintain_remark_doc.php');
		break;
		case 'emergency_remark_doc':
			require_once('emergency_remark_doc.php');
		break;
		
		case 'maintain_ltem_results_backup':
			require_once('maintain_ltem_results_backup.php');
		break;
		
		case 'set_maintain_item':
			require_once('set_maintain_item.php');
		break;
		
		case 'equipments':
			require_once('equipments.php');
		break;
		
		case 'equipments_edit':
			require_once('equipments_edit.php');
		break;
		
		case 'equipments_add':
			require_once('equipments_add.php');
		break;
		
		case 'machines':
			require_once('machines.php');
		break;
		
		case 'machines_edit':
			require_once('machines_edit.php');
		break;
		
		case 'machines_add':
			require_once('machines_add.php');
		break;
		
		case 'user':
			require_once('user.php');
		break;
		
		case 'users':
			require_once('user.php');
		break;
		
		case 'users_edit':
			require_once('users_edit.php');
		break;
		
		case 'users_add':
			require_once('users_add.php');
		break;
		case 'set_photo_report':
			require_once('set_photo_report.php');
		break;
		case 'user_equipments':
			require_once('user_equipments.php');
		break;
		
		default:
			echo 'Page not found.';
		break;
	}
	?>

<?php include("footer.php");?>