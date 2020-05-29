<?php
$db=new mysqli('localhost','USERNAME','PASSWORD');
if(isset($_POST['save']))
{
    $name=trim($_POST['name']);
    $phno=trim($_POST['phno']);
    if(!$name=='' || !$phno=='')
    {
        if(!$db->select_db('one'))
            $db->query('create database one');
        $db->select_db('one');
        if(!$db->query('select * from phno'))
            $db->query('create table phno(id int auto_increment primary key, name varchar(50), phnum varchar(20))');
        $db->query("insert into phno (name, phnum) values ('$name', '$phno')");
    }
}
?>
<html>
<head>
<title>My Phone Book</title>
</head>

<body>
<h1>My Phone Book</h1>
<h2 style="background: #000; color: #fff;">Store New Phone Number</h2>
<form name="form2" method="get" action="">
  <p style="background: #000; color: #fff;"><b>Search:</b>
    <input name="search" type="text" id="search">
    <input name="searchb" type="submit" id="searchb" value="Search">
  </p>
</form>
<p></p>
<form name="form1" id="form1" method="post" action="">
  <table width="250" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="83">Name</td>
      <td width="417"><input name="name" type="text" id="name" /></td>
    </tr>
    <tr> 
      <td>Ph. No.</td>
      <td><input name="phno" type="text" id="phno" value=""></td>
    </tr>
    <tr> 
      <td><input name="save" type="submit" id="save" value="Save" /></td>
      <td><input type="reset" name="Submit2" value="Reset" /></td>
    </tr>
  </table>
</form>
<h2 style="background: #000; color: #fff;">Previously Stored</h2>
<p>ORDER BY: <a href="?order=new">newest first </a>| <a href="?order=old">oldest 
  first</a> | <a href="?order=az">a-z</a> | <a href="?order=za">z-a</a></p>
</body>
</html>
<?php

$order=$_GET['order'];
if($order=='new')
    $query="select * from phno order by id desc";
elseif($order=='old')
    $query="select * from phno order by id asc";
elseif($order=='az')
    $query="select * from phno order by name asc";
elseif($order=='za')
    $query="select * from phno order by name desc";

elseif(isset($_GET['searchb']))
    {
        $search=$_GET['search'];
        $query="select * from phno where name like '$search%'";
    }
else
 
    $query="select * from phno";
    

if(!$db->select_db('one'))
{
    echo "<p><i>NONE</i></p>";
    exit;
}

$result=$db->query($query);

$num_rows=$result->num_rows;

if($num_rows<=0)
    echo "<p><i>No Match Found!</i></p>";

for($i=0;$i<$num_rows;$i++)
{

    $row=$result->fetch_row();

    echo "<p><span style=\"font-size: 200%;\">$row[1]: </span> $row[2]</p>";
}

$db->close();
?>