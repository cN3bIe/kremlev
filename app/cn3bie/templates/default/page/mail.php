<?php
date_default_timezone_set('Europe/Moscow');
cn3bie::incClass('FF');

$send = !1;

if( isset( $_POST['events'] ) ){
	cn3bie::incClass('Mail');
	$from='';
	$recipient = [
		'ocn3bieo@yandex.ru',
		'info@ilrusstroy.ru'
	];
	switch($_POST['events']){
		case 'enroll-on-free':
			FF::Install([
				'name'	=>['type'=>'text',	'slug'=>'Имя',									'empty'=>!0],
				'phone'	=>['type'=>'regex',	'slug'=>'Телефон',							'empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/'],
				'date'	=>['type'=>'text',	'slug'=>'Удобная дата и время',	'empty'=>!1],
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "Запишитесь на бесплатный выезд специалиста"',$recipient);
		break;
		case 'catalog-on-free':
			FF::Install([
				'name'	=>['type'=>'text',	'slug'=>'Имя',		'empty'=>!0],
				'phone'	=>['type'=>'regex',	'slug'=>'Телефон','empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/'],
				'email'	=>['type'=>'text',	'slug'=>'Email',	'empty'=>!1],
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "Получите бесплатно каталог проектов домов на ваш E-mail"',$recipient);
		break;
		case 'projects':
			FF::Install([
				'project'	=>['type'=>'text',	'slug'=>'Проект', 'empty'=>!0],
				'name'		=>['type'=>'text',	'slug'=>'Имя',		'empty'=>!0],
				'phone'		=>['type'=>'regex',	'slug'=>'Телефон','empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/']
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "Узнать подробнее о проекте"',$recipient);
		break;
		case 'project':
			FF::Install([
				'project'	=>['type'=>'text',	'slug'=>'Проект', 'empty'=>!0],
				'phone'		=>['type'=>'regex',	'slug'=>'Телефон','empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/']
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "Рассчитать точную стоимость под чистовую отделку"',$recipient);
		break;
		case 'excursion':
			FF::Install([
				'name'				=>['type'=>'text',	'slug'=>'Имя',									'empty'=>!0],
				'phone'				=>['type'=>'regex',	'slug'=>'Телефон',							'empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/'],
				'switch-view'	=>['type'=>'text',	'slug'=>'Что хотите посмотреть','empty'=>!0],
				'date'				=>['type'=>'text',	'slug'=>'Удобная дата и время',	'empty'=>!1],
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "Запишитесь на экскурсию по готовым или строящимся домам"',$recipient);
		break;
		case 'postroil':
			FF::Install([
				'name'				=>['type'=>'text',	'slug'=>'Имя',		'empty'=>!0],
				'phone'				=>['type'=>'regex',	'slug'=>'Телефон','empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/'],
				'email'				=>['type'=>'text',	'slug'=>'Email',	'empty'=>!1],
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "У вас есть проект дома, который вы хотите построить?"',$recipient, $_FILES);
		break;
		case 'test':
			FF::Install([
				'name'				=>['type'=>'text',	'slug'=>'Имя',									'empty'=>!0],
				'phone'				=>['type'=>'regex',	'slug'=>'Телефон',							'empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/'],
				'email'				=>['type'=>'text',	'slug'=>'Email',								'empty'=>!1],
				'area'				=>['type'=>'text',	'slug'=>'Желаемая площадь дома','empty'=>!0],
				'bedroom'			=>['type'=>'text',	'slug'=>'Количество спален',		'empty'=>!0],
				'otdel'				=>['type'=>'text',	'slug'=>'Тип отделки',					'empty'=>!0],
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "У вас есть проект дома, который вы хотите построить?"',$recipient);
		break;
		case 'feedback':
			FF::Install([
				'name'				=>['type'=>'text',	'slug'=>'Имя',														'empty'=>!0],
				'phone'				=>['type'=>'regex',	'slug'=>'Телефон',												'empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/'],
				'switcher'		=>['type'=>'text',	'slug'=>'Когда позвонить(переключатель)',	'empty'=>!0],
				'time'				=>['type'=>'text',	'slug'=>'Когда позвонить',								'empty'=>!0],
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "Заказать обратный звонок"',$recipient);
		break;
		case 'calc':
			FF::Install([
				'phone'		=>['type'=>'regex',	'slug'=>'Телефон',			'empty'=>!1,'regex'=>'/^\+?\s?\d\s?\(?\d{3}\)?\s?\d{3}(-|\s)?\d{2}(-|\s)?\d{2}$/'],
				'material'=>['type'=>'text',	'slug'=>'Материал дома','empty'=>!0],
				'floor'		=>['type'=>'text',	'slug'=>'Кол-во этажей','empty'=>!0],
				'area'		=>['type'=>'text',	'slug'=>'Площадь дома',	'empty'=>!0],
			])->GetFields($_POST)->CheckFields()->SendUserMail('Форма "Рассчитайте стоимость Вашего дома"',$recipient);
		break;
	}
}

$error = FF::GetError();
die(json_encode($error));
