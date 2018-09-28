<?php

require_once 'StorageRepository.php';
require_once 'UserMapper.php';
require_once 'User.php';
require_once 'DatabaseStartegy.php';

$storage = new StorageRepository(new DatabaseStartegy());
$storage->fetchData();
$mapper = new UserMapper($storage);
$mapper->build();

$user = $mapper->findById(3);

$user->setLogin('Vlad');
$mapper->save($user);