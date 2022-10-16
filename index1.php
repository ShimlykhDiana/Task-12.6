<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
  <title>Person info</title>
 </head>
 <body>
<?php

$persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
        
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];
?>
<span> Full name & parts of the name </span>
<br>
<br>
<?php
function getPartsFromFullname($fullName) {
$partsFromFullName = array_combine(['surname', 'name', 'patronymic'], explode(' ',$fullName));
return $partsFromFullName;
}

echo ('The result of the funciton <b>getPartsFromFullname</b>=');
print_r (getPartsFromFullname('Шимлых Диана Евгеньевна'));

function getFullnameFromParts($strSurname='Королько',$strName='Анастасия',$strPatronymic='Владимировна') {
    $fullName = $strSurname.' '.$strName.' '.$strPatronymic;
    return $fullName;
};
?> 
<br>
<?php
echo ('The result of the funciton <b>getFullnameFromParts</b> for "Королько", "Анастасия", "Владимировна" = ');
echo (getFullnameFromParts('Королько', 'Анастасия', 'Владимировна'));
?> 
<span> </span>
<br>
<br>


<span> Short Name </span>
<br>
<br>
<?php
function getShortName ($fullName = 'Иванов Иван Иванович') {
    $strShortName = getPartsFromFullname($fullName) ['name'] .' '. mb_substr(getPartsFromFullname($fullName)['surname'], 0, 1) . '.';  //is it working using array?
    return $strShortName;
}
echo ('The result of the function <b> getShortName </b> for Иванов Иван Иванович=');
echo getShortName('Иванов Иван Иванович');
?>
<br>
<br>


<span> Defining a gender from a name  </span>
<br>
<br>
<?php
function getGenderFromName ($fullName = 'Иванов Иван Иванович') {
    $partsFromFullName = getPartsFromFullname($fullName);
    $genderZero = 0;
   
    if (mb_substr($partsFromFullName['patronymic'], -2) == 'ич') {
        $genderZero++;
    } 
    elseif ((mb_substr($partsFromFullName['name'], -1) == 'й') 
    || (mb_substr($partsFromFullName['name'], -1) == 'н')){
        $genderZero++;
    }
    elseif (mb_substr($partsFromFullName['surname'], -1) == 'в'){
        $genderZero++;
    }

if (mb_substr($partsFromFullName['patronymic'], -3) == 'вна'){
    $genderZero--;
    }
    else if (mb_substr($partsFromFullName['name'], -1) == 'а'){
    $genderZero--;
    }
    else if (mb_substr($partsFromFullName['surname'], -2) == 'ва'){
    $genderZero--;
    }
    
    return $genderZero <=> 0;
};
echo ('The result of the function <b> getGenderFromName </b> for Ахматова Анна Андреевна=');
echo getGenderFromName('Ахматова Анна Андреевна');

// $everybody = getGenderFromName($persons_array);
?>
<br>
<br>

<span> Gender composition  </span>
<br>
<br>
<?php

function getGenderDescription ($persons_array) {

    $men = array_filter($persons_array, function ($persons_array) {
    return getGenderFromName($persons_array['fullname']) == 1;
});
    $women = array_filter($persons_array, function ($persons_array) {
    return getGenderFromName($persons_array['fullname']) == -1;
}); 
    $notDefined = array_filter($persons_array, function ($persons_array) {
    return getGenderFromName($persons_array['fullname']) == 0;
});

$man = round((count ($men)/count ($persons_array)* 100), 2); // 1 - number signs after a dot
$woman = round((count ($women)/count($persons_array)*100), 2);
$other = round((count($notDefined)/count($persons_array)*100), 2);

return 'Gender composition of the audience:'.PHP_EOL.''.PHP_EOL.'men - '.$man.'%'.PHP_EOL.'women - '.$woman.'%'.PHP_EOL.'Not defined - '.$other.'%';
}
echo getGenderDescription($persons_array);
?>
<br>
<br>


<span> Perfect match </span>
<br>
<br>
<?php

function getPerfectPartner($strSurname,$strName,$strPatronymic,$persons_array){
    $fullName=mb_convert_case(getFullnameFromParts($strSurname,$strName,$strPatronymic), MB_CASE_TITLE);
    $gender=getGenderFromName($fullName) * (-1);
    do {
      $randomPeron=$persons_array[rand(1,count($persons_array)-1)]; // fetch a random person from the array
      $match=$randomPeron['fullname'];
    } while ( getGenderFromName( $match ) !== $gender); // check for opposite sex
    $matchValue=(rand(5000,10000))/100;
    return getShortName($fullName).' + '.getShortName($match).' ='.PHP_EOL.'&#9825;  Perfect for '.$matchValue.'% &#9825;';
    }

// var_dump (getGenderDescription($everybody)); 
// echo ('The result of the function <b> getPerfectPartner </b> =');
echo getPerfectPartner('Жарова', 'Наталья', 'Александровна', $persons_array);
?> <br> <br>