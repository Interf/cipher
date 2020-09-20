<?php
/*
Список символов:
AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz1234567890!@#$%&?-+=~^*()_;:,./\|`[]{}'"
*/


function dump($data)
{
	echo "<pre>". print_r($data, 1) . "</pre>";
}


	// Уравнивание длины ключа\хэша с паролем
function checkKey($key, $pass_hash)
{
	$count_key = mb_strlen($key);
	$count_pass = mb_strlen($pass_hash);

	if($count_key < $count_pass) {
		$key = str_pad($key, $count_pass, $key);
	} elseif($count_key > $count_pass) {
		$key = substr($key, 0, $count_pass);
	} else {
		return $key;
	}

	return $key;
}


	// Функция создания хэша
function encode($pass, $my_key)
{
	global $alphabet, $main_alpha;
	$my_key = checkKey($my_key, $pass);
	$count_pass = mb_strlen($pass);
	$result = "";

	for($a = 0; $a < $count_pass; $a++) {
			// Символы пароля как индексы нужного массива в $alphabet
		$side = array_search($pass[$a], $main_alpha, true);
		
			// Символы ключа как индексы нужной позиции в выбраном массиве($side)
		$upper = array_search($my_key[$a], $main_alpha); 

		$result .= $alphabet[$side][$upper];
	}

	return $result;
}


	// Функция расшифровки хэша
function decoder($hash, $my_key) 
{
	global $alphabet, $main_alpha, $count;
	$count_hash = mb_strlen($hash); 
	$result = "";

	$my_key = checkKey($my_key, $hash);

	for($j = 0; $j < $count_hash; $j++) {
		$key = array_search($my_key[$j], $main_alpha);
		
		for($i = 0; $i < $count; $i++) {
			if($alphabet[$i][$key] === $hash[$j]) {
				$result .= $main_alpha[$i];
				break;
			}
		}
	}

	return $result;
}

	// Основной массив
$main_alpha = unserialize(file_get_contents('main_alpabet.txt'));

	// Ключ шифрования
$key = "!@#$%?My-+=1Key~12345";

	// Кол-во элементов в массиве
$count = count($main_alpha);

	// Формирование шифрующего квадрата(массив $alphabet)
$newArr[] = $main_alpha;
for($i = 0; $i < $count - 1; $i++) {
	$newArr[$i+1] = $newArr[$i];
	$temp_var = array_shift($newArr[$i+1]);
	array_push($newArr[$i+1], $temp_var);
}
$alphabet = $newArr;

	// Пароль, который шифруется
$pass = "1My222Password333!@#$%?-+=~";
	// Хэш зашифрованного пароля
$hash = encode($pass, $key);
	// Ключ, равный длине пароля(записан тут только для информации) 
$new_key = checkKey($key, $pass);
	// Визуализация данных + их длина
dump($key." :- key ".mb_strlen($key));
dump($new_key." :- new key ".mb_strlen($new_key));
dump($pass." :- pass ".mb_strlen($pass));
dump($hash." :- hash ".mb_strlen($hash));

echo "<hr>";
	// Расшифровка хэша
dump(decoder($hash, $key));
echo "<hr>";