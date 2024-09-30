<?php
class Func
{
    private $conn;
    public $id;
	public $first_name;
	public $last_name;
	public $code13;

    public function __construct($db)
    {
        $this->conn = $db;
    }


// Create
function createPerson()
{
	$name = @$_POST['first_name'];
	$last_name = @$_POST['last_name'];
	$code13 = @$_POST['code13'];
	$depa = @$_POST['depa'];
	$begin_date = @$_POST['begin_date'];
	$end_date = @$_POST['end_date'];
	$course = @$_POST['course'];
	$target_dir = "colegeImg/".$name.' '.$last_name .'.jpg';
	if(isset($_FILES['imageToUpload'])){
		move_uploaded_file($_FILES['imageToUpload']['tmp_name'], $target_dir);
	  }
	  else{
		  echo "image not found!";
	  }
	   
if (isset($_POST['submit']) ) {
	$sql = ("INSERT INTO `colege`(`first_name`, `last_name`, `code13`,`departament`,`begin_date`,`end_date`,`img`,`temp`) VALUES(?,?,?,?,?,?,?,?)");
	$query = $this->conn->prepare($sql);
	$query->execute([$name, $last_name, $code13, $depa, $begin_date, $end_date, $target_dir,$course]);
	$success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Данные успешно отправлены!</strong> Вы можете закрыть это сообщение.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
	return $success;
}
}

// Read
function getPerson()
{
	$query = "SELECT * FROM `colege` order by temp, departament, last_name;";
	$stmt = $this->conn->prepare($query);
	$stmt->execute();
	return $stmt;
}

// Update
function updatePerson()
{
$edit_name = @$_POST['edit_name'];
$edit_last_name = @$_POST['edit_last_name'];
$edit_pos = @$_POST['edit_pos'];
$depa = @$_POST['depa'];
$get_id = @$_GET['id'];
if (isset($_POST['edit-submit'])) {
	$sqll = "UPDATE colege SET first_name=?, last_name=?, code13=?, departament=? WHERE id=?";
	$querys = $this->conn->prepare($sqll);
	$querys->execute([$edit_name, $edit_last_name, $edit_pos, $depa, $get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}
}

// DELETE
function deletePerson()
{
	$get_id = @$_GET['id'];
if (isset($_POST['delete_submit'])) {
	$sql = "DELETE FROM colege WHERE id=?";
	$query = $this->conn->prepare($sql);
	$query->execute([$get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}
}
}
