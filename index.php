<?php





$token = '1400886880:AAElF7Kg8oIqKulnQ8bTnIV0hj8CgKi32co';

$update = file_get_contents("php://input");
$update = json_decode($update, true);


$text = $update["message"]["text"];
$youtubeURL = $text;

$chat_id = $update["message"]["chat"]["id"];
$username = $update["message"]["from"]["username"];
$fname = $update["message"]["from"]["first_name"];
$lname = $update["message"]["from"]["last_name"];

// Mengumpulkan Function


function sendMes($token, $chat_id, $mes){
$mes = rawurlencode($mes);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$mes");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
}



// Terdeteksi Start


if(preg_match("/\/start/i", $text)){
$mes = "Untuk melihat panduan pemakaian, ketik /help";
sendMes($token, $chat_id, $mes);
exit();
}


// Terdeteksi help


if(preg_match("/\/help/i", $text)){

$mes = 'Langkah-langkah Penggunaan

1️⃣ Pilih video yang ingin kamu unduh dari YouTube

2️⃣ Klik tombol "bagikan"

3️⃣ Lalu klik "salin link"

4️⃣ Setelah link tersalin, Pastekan link tersebut di bot ini

5️⃣ Lalu bot akan mengirimkan bermacam-macam resolusi yang bisa kalian download

6️⃣ Pilih resolusi sesuai keinginanmu lalu klik "download"

7️⃣ Maka secara otomatis akan diarahkan ke browser

8️⃣ Lalu kalian klik titik 3 di bagian kanan bawah video

9️⃣ Lalu klik "download". Done😁😁

🔟 Jika masih bingung, kalian bisa tonton video berikut 👇';
sendMes($token, $chat_id, $mes);

$file_id = 'BAACAgUAAxkBAAOUX569aorDKjOElP-iKVKEGt0hZIAAAjEBAAJ54flU3fBoeHM1zbkeBA';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$token/sendVideo?chat_id=$chat_id&video=$file_id");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

exit();
}









// Youtube video url

if (preg_match("/youtu.be/", $youtubeURL)){
$a = explode("https://youtu.be/", $youtubeURL);
$youtubeURL = "https://www.youtube.com/watch?v=".$a[1];
}else{
}

$i = explode("https://www.youtube.com/watch?v=", $youtubeURL);
$id = $i[1];






system("clear");
$respon = file_get_contents("https://www.youtube.com/get_video_info?video_id=$id");





parse_str($respon, $data);
$data1 = $data["player_response"];
$data1 = json_decode($data1, true);
$data1 = $data1['streamingData'];
$streamingDataFormats = $data1['formats'];
$streamingDataFormats2 = $data1['adaptiveFormats'];



foreach ($streamingDataFormats as $data1){
	$videoTitle = $data1['title'];
	$videoFormat = $data1['mimeType'];
	$aaa = explode(';', $videoFormat);
	$videoFormat = $aaa[0];
	if ($data1['qualityLabel']){
        $downloadTeks[] = $data1['qualityLabel'].' '.$videoFormat;
        }else{
        $downloadTeks[] = $videoFormat;
        }
        $videoFileName = strtolower(str_replace(' ', '_', $videoTitle)).'.'.$videoFormat;
        $downloadURL[] = $data1['url'];
        $fileName = preg_replace('/[^A-Za-z0-9.\_\-]/', '', basename($videoFileName));
}
foreach ($streamingDataFormats2 as $data5){
	$videoTitle = $data5['title'];
	$videoFormat = $data5['mimeType'];
	$aaa = explode(';', $videoFormat);
        $videoFormat = $aaa[0];
	if ($data5['qualityLabel']){
        $downloadTeks[] = $data5['qualityLabel'].' '.$videoFormat;
	}else{
	$downloadTeks[] = $videoFormat;
	}
        $downloadURL[] = $data5['url'];
}


$no = -1;
$jumlah = count($downloadURL);
while ($no < $jumlah){
$no++;
$keyboard = [
        'inline_keyboard' => [
		[
[
"text" => "Download",
"url" => $downloadURL[$no]
],
		],
        ],
    ];



$postfields = array(
'chat_id' => "$chat_id",
'text' => $downloadTeks[$no],
'reply_markup' => json_encode($keyboard)
);


$curld = curl_init();
curl_setopt($curld, CURLOPT_POST, true);
curl_setopt($curld, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($curld, CURLOPT_URL, "https://api.telegram.org/bot$token/sendMessage");
curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($curld);

}
/*
$keyboard = arr($streamingDataFormats, $streamingDataFormats2);
file_put_contents("key.txt", json_encode($keyboard, JSON_PRETTY_PRINT));
$keyboard = file_get_contents("key.txt");
$mes = $keyboard;
sendMes($token, $chat_id, $mes);
*/


/*
$no = -1;
while ($no <= count($downloadURL)){
$no++;
$noo = $no+1;
$nooo = $noo+1;
$noooo = $nooo+1;
$keyboard = [
        'inline_keyboard' => [
            [

[
"text" => $videoQuality[$no]." ".$videoFormat[$no],
"url" => $downloadURL[$no]
],
[
"text" => $videoQuality[$noo]." ".$videoFormat[$noo],
"url" => $downloadURL[$noo]
],
[
"text" => $videoQuality[$nooo]." ".$videoFormat[$nooo],
"url" => $downloadURL[$nooo]
],
[
"text" => $videoQuality[$noooo]." ".$videoFormat[$noooo],
"url" => $downloadURL[$noooo]
]

            ],
        ],
    ];



$no = $noooo;
$postfields = array(
'chat_id' => "$chat_id",
'text' => "Download disini",
'reply_markup' => json_encode($keyboard)
);

if (!$curld = curl_init()) {
exit;
}


curl_setopt($curld, CURLOPT_POST, true);
curl_setopt($curld, CURLOPT_POSTFIELDS, $postfields);
curl_setopt($curld, CURLOPT_URL, "https://api.telegram.org/bot$token/sendMessage");
curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($curld);
}
*/




?>
