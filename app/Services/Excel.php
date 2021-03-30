<?php
namespace App\Services;

class Excel
{

  public function __construct()
  {

  }

  public function export($headers, $vals, $name="registros")
  {
      header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
      header("Content-Disposition: attachment; filename=".$name."_".date_create('now')->format('d-m-Y_H:i:s').".xls");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: private",false);


      echo "<table border='1' cellpadding='2' cellspacing='0' width='100'>";
      echo "<tr> ";
      echo  "<th style='font-size:14px;' colspan='".count($headers)."'>REPORTE DE REGISTROS - ". $name ."</th> ";
      echo "</tr> ";
      echo "<tr> ";
      foreach ($headers as $var) {
        echo  '<th style="background-color: beige;font-size:16px;width:120px">'.$var.'</th>';
      }
      echo "</tr> ";


      foreach ($vals as $val) {
          echo "<tr> ";
          foreach ($val as $data) {
              echo 	"<td style='font-size:14px;'>".$data."</td> ";
          }
          echo "</tr> ";
      }
      echo "</table> ";

  }

}
