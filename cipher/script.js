/*
Список символов:
AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz1234567890!@#$%&?-+=~^*()_;:,./\|`[]{}'"
*/

	// Массив символов
let mainAlpha = ["A","a","B","b","C","c","D","d","E","e","F","f","G","g","H","h","I","i","J","j","K","k","L","l","M","m","N","n","O","o","P","p","Q","q","R","r","S","s","T","t","U","u","V","v","W","w","X","x","Y","y","Z","z","1","2","3","4","5","6","7","8","9","0","!","@","#","$","%","&","?","-","+","=","~","^","*","(",")","_",";",":",",",".","\/","\\","|","`","[","]","{","}","'","\""];


	// Формирование шифрующего квадрата(массив alphabet)
const count = mainAlpha.length;

newArr = {0 : mainAlpha}
let tempVar;
for(let i = 0; i < count - 1; i++) {
	newArr[i+1] = newArr[i].slice();
	tempVar = newArr[i+1].shift();
	newArr[i+1].push(tempVar); 
}
const alphabet = newArr;


	// Уравнивание длины ключа с паролем\хэшем
function checkKey(key, pass_hash)
{
	const countKey = key.length;
	const countPass = pass_hash.length;

	if(countKey < countPass) {
		key = key.padEnd(countPass, key);
	} else if(countKey > countPass) {
		key = key.substr(0, countPass);
	} else {
		return key;
	}

	return key;
}

	// Функция создания хэша
function encode(pass, myKey)
{
	myKey = checkKey(myKey, pass);
	const countPass = pass.length;
	let side, upper, result = "";

	for(let a = 0; a < countPass; a++) {
			// Символы пароля как индексы нужного массива в alphabet		
		side = mainAlpha.indexOf(pass[a]);

			// Символы ключа как индексы нужной позиции в выбраном массиве(side)
		upper = mainAlpha.indexOf(myKey[a]);

		result += alphabet[side][upper];
	}

	return result;
}

	// Функция расшифровки хэша
function decoder(hash, myKey) 
{
	const countHash = hash.length; 
	let indexKey, result = "";

	myKey = checkKey(myKey, hash);

	for(let j = 0; j < countHash; j++) {
		indexKey = mainAlpha.indexOf(myKey[j]);

		for(let i = 0; i < count; i++) {
			if(alphabet[i][indexKey] === hash[j]) {
				result += mainAlpha[i];
				break;
			}
		}
	}

	return result;
}



const key = "!@#$%?My-+=1Key~12345";
const pass = "1My222Password333!@#$%?-+=~";
const newKey = checkKey(key, pass);
const hash = encode(pass, key);

console.log('Your key: ', key, " - length:", key.length);
console.log('Your new key: ', newKey, " - length:", newKey.length);
console.log('Your pass: ', pass," - length:", pass.length);
console.log("Encode; Your hash", hash);
console.log("Decoder; Your password", decoder(hash, key));