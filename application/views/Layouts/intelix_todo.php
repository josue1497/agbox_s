<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Intelix Synergy">

	<title>
		{{ app_title }}
	</title>
		{{ intelix_todo_styles }} 
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
		{{ intelix_todo_side }}
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content" class="bg-info">
		{{ intelix_todo_topbar }}
		<!-- --- BEGIN CARD ---- -->
		{{ intelix_todo_content }}
		<!-- --- END CARD ---- -->
      </div>
      <!-- End of Main Content -->
		{{ intelix_todo_footer }}
    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
	{{ intelix_todo_scripts }}
</body>
</html>