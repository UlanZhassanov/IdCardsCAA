<?php
include_once "database.php";
include_once "func.php";
include_once "createpdf.php";
/*$dir='upload';
$files=scandir($dir);
//var_dump($files);
$rez=explode(".",$files[3]);
$rez2=explode(" ",$rez[0]);
echo $rez2[1];*/

$database = new Database;
$db = $database->getConnectionMysql();
$func = new Func($db);
$stmtGet = $func->getPerson();
$stmtCreate = $func->createPerson();
$stmtUpdate = $func->updatePerson();
$stmtDelete = $func->deletePerson();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CRUD приложение на PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
</head>

<body>
    <h1 align="center">ID Cards</h1>
    <div class="container">
        <div class="row">
            <div class="col mt-1">
                <?php
                if (isset($success))
                    echo $success;
                if (isset($pdfCreated))
                    echo $pdfCreated;
                ?>
                <br>
                <button class="btn btn-success mb-1" data-toggle="modal" data-target="#Modal"><i class="fa fa-user-plus"></i></button>
                <form method="post" style="display: inline-block;">
                    <input type="submit" name="createAllPdf" value="PDF" class="btn btn-success btn-sm" data-toggle="modal"></input>
                </form>
                <form method="post" style="display: inline-block;">
                    <input type="submit" name="create1CoursePdf" value="1 курс" class="btn btn-success btn-sm" data-toggle="modal"></input>
                </form>
                <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                                       aria-describedby="example1_info">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Штрих код</th>
                            <th>Группа</th>
                            <th>Дата начала</th>
                            <th>Дата окончания</th>
                            <th>Статус</th>
							<th>Курс</th>
                            <th>Действие</th>
                        </tr>
                        <?php while ($row = $stmtGet->fetch(PDO::FETCH_ASSOC)) {

                            extract($row);
                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $first_name ?></td>
                                <td><?= $last_name ?></td>
                                <td><?= $code13 ?></td>
                                <td><?= $departament ?></td>
                                <td><?= $begin_date ?></td>
                                <td><?= $end_date ?></td>
                                <td><?= $status ?></td>
								<td><?= $temp ?></td>
                                <td>
                                    <a href="?edit=<?= $id ?>" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModal<?= $id ?>"><i class="fa fa-edit"></i></a>
                                    <a href="?delete=<?= $id ?>" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $id ?>"><i class="fa fa-trash"></i></a>
                                    <form method="post" style="display: inline-block;">
                                        <input type="hidden" name="idforpdf" value="<?= $id ?>" />
                                        <input type="submit" name="createOnePdf" value="PDF" class="btn btn-success btn-sm" data-toggle="modal"></input>
                                    </form>
                                    <!-- Modal Edit-->
                                    <div class="modal fade" id="editModal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content shadow">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Редактировать запись № <?= $id ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="?id=<?= $id ?>" method="post">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="edit_name" value="<?= $first_name ?>" placeholder="Имя">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="edit_last_name" value="<?= $last_name ?>" placeholder="Фамилия">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="edit_pos" value="<?= $code13 ?>" placeholder="Должность">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="depa" value="<?= $departament ?>" placeholder="Должность">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit-submit" class="btn btn-primary">Обновить</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- DELETE MODAL -->
                                    <div class="modal fade" id="deleteModal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content shadow">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Удалить запись № <?= $id ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                    <form action="?id=<?= $id ?>" method="post">
                                                        <button type="submit" name="delete_submit" class="btn btn-danger">Удалить</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr> <?php } ?>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="Modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить пользователя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" value="" placeholder="Имя">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="last_name" value="" placeholder="Фамилия">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="code13" value="" placeholder="Штрих код">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="depa" value="" placeholder="Группа">
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control" name="begin_date" value="" placeholder="Дата начала">
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control" name="end_date" value="" placeholder="Дата окончания">
                        </div>
						 <div class="form-group">
                            <input type="text" class="form-control" name="course" value="" placeholder="Курс">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="imageToUpload" value="" placeholder="Фото">
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" name="submit" class="btn btn-primary">Добавить</button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <script>
      $(function () {

        $('#example1').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
        })

        jQuery('#example1_wrapper input').addClass("form-control input-sm"); // modify table search input
      })


</script>                     

    <script src="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>                 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>