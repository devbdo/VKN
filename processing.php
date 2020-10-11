<?php
ob_start();
session_start();

function curl_get($url) {

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true
    ]);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function curl_post($url, $params) {

    $postData = '';
    foreach($params as $k => $v) {
        $postData .= $k . '='.$v.'&';
    }
    rtrim($postData, '&');

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
    ]);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;

}

if (isset($_POST['sorgula'])) {
    $VergiKimlikNumarası = $_POST['vkn'];
    $VergiDairesi = $_POST['vd'];

    if ($_POST['jeton'] != $_SESSION['jeton']) {

      echo '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      Jeton geçerli değil.
      </div>';

    } elseif (!ctype_digit($VergiKimlikNumarası) or strlen($VergiKimlikNumarası) < 10 or strlen($VergiKimlikNumarası) > 10) {
        echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Girilen vergi kimlik numarası geçerli değil. 
        </div>';

    } elseif ($VergiDairesi == NULL) {
        echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Seçilen vergi dairesi geçerli değil.
        </div>';

    } else {

        $data = [
            'vkn' => $VergiKimlikNumarası,
            'vd' => $VergiDairesi
        ];

        $post = curl_post('https://www.my-api.co/vkn.php', $data);
        $decode = json_decode($post, true);

        if ($decode['error'] == 1) {
 
        echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        '.$decode['message'].'
        </div>';

        } else {
            echo '<div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b>Durum:</b> ' . $decode['data']['status'] . ' - <b>Ünvan:</b> ' . $decode['data']['title'].'
            </div>';

        }
    }

    $_SESSION['jeton'] = rand(100000, 999999);

}

$_SESSION['jeton'] = rand(100000, 999999);
$token = $_SESSION['jeton'];
?>