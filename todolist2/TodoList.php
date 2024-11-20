<?php

namespace TODOLIST\todolist1;

require_once 'Task.php';

use TODOLIST\todolist1\Task;



class TodoList
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
        $tasksJson = file_get_contents('Task.json');
        $tasks = json_decode($tasksJson, true);
        $userTasks = [];
        foreach ($tasks as $index => $task) {
            if (isset($task['userName']) && $task['userName'] == $userName) {
                $task['indexIndata'] = $index;
                $userTasks[] = $task;
            }
        }
        return $userTasks;
    }
}
