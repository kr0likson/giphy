<?php
session_start();
if(isset($_POST['nazwa'])) {
  $_SESSION['nazwa1']=$_POST['nazwa'];
}
  function giphy(){
require_once('./giphy-php-client-master/vendor/autoload.php');
$api_instance = new GPH\Api\DefaultApi();
$api_key = "dc6zaTOxFJmzC"; // string | Giphy API Key.
$offset = 0;
$q = $_SESSION['nazwa1'];
$limit = 25; // string | Filters results by specified tag.
$rating = "g"; // string | Filters results by specified rating.
$fmt = "json"; // string | Used to indicate the expected response format. Default is Json.
$lang = "en";
try {
    $result = $api_instance->gifsSearchGet($api_key, $q, $limit, $offset, $rating, $lang, $fmt);
  //print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->gifsSearchGet: ', $e->getMessage(), PHP_EOL;
}

$adr = array();
$rozmiar=count($result['data']);
require_once('connect.php');
$polaczenie = @new mysqli($host,$db_user,$db_password,$db_name);
if($polaczenie->connect_errno){
  echo "Error: ".$polaczenie->connect_errno." Opis: ".$polaczenie->connect_error;
}
else{
  $ip = $_SERVER['REMOTE_ADDR'];
  $sql_user = "SELECT id FROM users WHERE ip='$ip'";
  if($wynik_user = @$polaczenie->query($sql_user)){
    $ilu_userow = $wynik_user->num_rows;
    if($ilu_userow>0){
      $wiersz = $wynik_user->fetch_assoc();
      $user = $wiersz['id'];
      $wynik_user->free_result();
    }
    else{
      $sql_create_user = "INSERT INTO users (id, ip) VALUES (NULL, \"$ip\")";
      if($dodaj_usera = @$polaczenie->query($sql_create_user)){
          if($wynik_user = @$polaczenie->query($sql_user)){
            $wiersz = $wynik_user->fetch_assoc();
            $user = $wiersz['id'];
            $wynik_user->free_result();
          }
      }
      else{
        echo "Błąd przy dodawaniu nowego użytkownika";
      }
    }
  }

for($i=0;$i<$rozmiar;$i++){
  $id_obrazka[$i] = $result['data'][$i]['id'];
  $sql_obrazek = "SELECT id_o, polubienia, id_giphy FROM obrazki WHERE id_giphy=\"$id_obrazka[$i]\"";
  if($wynik_obrazek = @$polaczenie->query($sql_obrazek)){
    $ile_obrazkow = $wynik_obrazek->num_rows;
    if($ile_obrazkow>0){
      $wiersz = $wynik_obrazek->fetch_assoc();
      $obrazek[$i] = $wiersz['id_o'];
      $polubienie[$i] = $wiersz['polubienia'];
      $lajki[$i]=$polubienie[$i];
      $wynik_obrazek->free_result();
    }
    else{
      $sql_create_image = "INSERT INTO obrazki (id_o, id_giphy, polubienia) VALUES (NULL, \"$id_obrazka[$i]\", 0)";
      if($dodaj_obrazek = @$polaczenie->query($sql_create_image)){
          if($wynik_obrazek = @$polaczenie->query($sql_obrazek)){
            $wiersz = $wynik_obrazek->fetch_assoc();
            $obrazek[$i] = $wiersz['id_o'];
            $polubienie[$i] = $wiersz['polubienia'];
            $lajki[$i]=$polubienie[$i];
            $wynik_obrazek->free_result();
    }
  }
  else{
    echo "Błąd przy dodawaniu nowego obrazka";
  }
  }
  }
$sql_lubie = "SELECT lubi FROM czylubi WHERE id=\"$user\" AND id_obrazka=\"$obrazek[$i]\"";
if($wynik_lubie = @$polaczenie->query($sql_lubie)){
  $ile_polubien = $wynik_lubie->num_rows;
  if($ile_polubien>0){
    $wiersz = $wynik_lubie->fetch_assoc();
    $lubieto[$i] = $wiersz['lubi'];
    $lajk[$i]=$lubieto[$i];
    $wynik_lubie->free_result();
}
  else{
$sql_add_like = "INSERT INTO czylubi (id_statusu, id, id_obrazka, lubi) VALUES (NULL,'$user','$obrazek[$i]',0 )";
if($dodaj_lubie = @$polaczenie->query($sql_add_like)){
    if($wynik_like = @$polaczenie->query($sql_lubie)){
      $wiersz = $wynik_lubie->fetch_assoc();
      $lubieto[$i] = $wiersz['lubi'];
      $lajk[$i]=$lubieto[$i];
      $wynik_lubie->free_result();
}
}
else{
  echo "Błąd przy dodawaniu lajka";
}
}
}

if(isset($_POST['lajk']) && isset($_POST['image'])){
  if($_POST['image'] == $obrazek[$i]){
    $lick=$_POST['lajk'];
    switch($lick){
      case 0:
      $sql_lajk = "UPDATE czylubi SET lubi = 1 WHERE id=\"$user\" AND id_obrazka=\"$obrazek[$i]\"";
      $lajki[$i] = $polubienie[$i]+1;
      $sql_polubienia = "UPDATE obrazki SET polubienia=\"$lajki[$i]\" WHERE id_o=\"$obrazek[$i]\"";
      $lajk[$i] = 1;
      break;
      case 1:
      $sql_lajk = "UPDATE czylubi SET lubi = 0 WHERE id=\"$user\" AND id_obrazka=\"$obrazek[$i]\"";
      $lajki[$i] = $polubienie[$i]-1;
      $sql_polubienia = "UPDATE obrazki SET polubienia=\"$lajki[$i]\" WHERE id_o=\"$obrazek[$i]\"";
      $lajk[$i] = 0;
      break;
    }
      $nowy_lajk = @$polaczenie->query($sql_lajk);
      $liczba_polubien = @$polaczenie->query($sql_polubienia);
  }
}

$adr[$i] = $result['data'][$i]['images']['fixed_height']['url'];
if($lajk[$i] == 0) $style="float:left;padding:2.5px;";
else $style="background:#8FD8D8;float:left;padding:2.5px";
echo <<<ID1
<div class="blok">
<img src="$adr[$i]">
<br>
<div style="width: 10px;border: 1px solid black; padding: 2px;float:left;">$lajki[$i]</div>
<form action="index.php" method="post">
<input type="hidden" name="image" value="$obrazek[$i]">
<input type="hidden" name="lajk" value="$lajk[$i]">

<input type="submit" name="submit" value="Lubie to" style="$style">
</form>
</div>
ID1;
$current_url = "index.php";
if(isset($_POST['submit'])){
$submit=$_POST['submit'];
if($submit==true){
  header("Location: $current_url");
  $submit==false;

}
}
}

}


}
?>
<!DOCTYPE html>
<html>
<head>
  <style>
  .blok{
    padding: 10px;
    border: 1px solid black;
    float:left;
  }
  </style>
</head>
<body>
  <form method="post" action="index.php">
    <input type="text" name="nazwa">
    <br><br>
    <input type="submit" value="Wyslij">
  </form>
    <br><br><br>
<?php
if(isset($_SESSION['nazwa1'])){
  giphy();
}
?>
</body>
</html>
