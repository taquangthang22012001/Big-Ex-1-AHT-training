<?php

namespace TODOLIST\todolist1;
include"../Model/Task.php";

use PDO;
use TODOLIST\todolist1\Task;

class TodoListController
{
    public static function addTask($userName, $title, $content, $priority)
    {

        $newTask = new Task($title, $content, $priority);
        $newTask->saveTask($userName);
    }
    public static function removeTask($index)
    {
        return Task::deleteTask($index);
    }
    public  static function editTask($index, $title = null, $status = null, $content = null, $priority = null)
    {
        return Task::editTask($index, $title, $status, $content, $priority);
    }
    public static function search($userName, $Title)
    {
        return Task::search($userName, $Title);
    }
    public static function filter($userName, $priority)
    {
        return Task::filter($userName, $priority);
    }
    public static function getTasks($userName)
    {
        $conn =connectdb();
        $stmt = $conn->prepare("SELECT * FROM task");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
}
