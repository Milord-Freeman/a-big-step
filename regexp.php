<?php

// Требуется написать регулярку, которая будет пропускать через
// себя телефонные номера в формате 88005553535, в т.ч. с пробелами
// и тире, скобочками и без них.

// Сначала делаем список номеров, который будем гонять через регулярку.
const PHONES = array(
    "88005553535", // Ok;
    "8(801)555(35)35", // Ok;
    "8-802-555-35-35", // Ok;
    "8(803)(555)(35)(35)", // Ok;
    "8-(804)-(555)-(35)-(35)", // Ok;
    "8 805 555 35 35", // Ok;
    "---(8)---(8)(0)(6)---(5)(5)(5)---(3)(5)---(3)(5)---", // Как бы странно не казалось, но ок.
    "8807", // Неверно, т.к. длина номера < 10 цифр;
    "88085553535555", // Неверно, т.к. длина номера > 10 цифр;
    "8809555aaaa", // Неверно, т.к. присутстует латиница;
    "FooBar"// Также неверно.
); // Итого 11 номеров, из которых 7 верных.

error_reporting(-1);

$regexp = "/[-()\\s]*([0-9][-()\\s]*){11}/";
// Сначала возможно встретится один из символов [-()] или пробел, сколько угодно раз,
// затем обязательно одиннацать блоков, состоящие из одной цифры [0-9],
// и возможно еще из символов [-()] (и пробела), сколько угодно раз.
// Вообще т.к. нам не нужны тут буквы, то и регистр, и кодировка оных
// нам не важна, и флаги 'ui' не нужны.
// P.s. Для России упростить на '8' или '+7' в начале, и десять блоков.

$rightPhones = []; // Создаем пустой массив для правильных номеров;
$wrongPhones = []; // И для неправильных;

foreach(PHONES as $phone){
    $match = []; // Создаем пустой массив для записи туда номера через preg_match;
    if (preg_match($regexp, $phone, $match)){ // Если номер пройдет через регулярку, то будет записан в $match[0];
        $rightPhones[] = $match[0]; // И добавлен в массив с правильными номерами;
    }
    else
        $wrongPhones[] = $phone; // Иначе же добавляем номер в массив с неправильными;
}

echo "Правильные номера: \n"; // Выводим список правильных номеров;
foreach($rightPhones as $phone){ // Используя для этого поэлементный проход массива через foreach();
    echo "$phone \n";
}

echo "Неправильные номера: \n"; // И так же для неправильных;
foreach($wrongPhones as $phone){
    echo "$phone \n";
}

// TODO:
// 1. Реализовать вывод данных массива не поэлементным проходом,
// а каким-нибудь var_dump(), чтобы не плодить лишних переменных.
// Ну и изучить форматированный вывод данных.
// 2. Реализовать перевод данных из массива в удобочитаемый вид
// "88005553535" - т.е. нужно будет убрать весь мусор из строки.
