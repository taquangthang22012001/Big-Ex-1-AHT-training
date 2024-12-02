<?php

namespace TODOLIST\todolist1;
class Task
{
    private $title;
    private $status = 'incomplete';
    private $content;
    private $priority;
    private $isCompleted = 0;

    public function __construct($title, $content, $priority)
    {
        $this->title = $title;
        $this->content = $content;
        $this->priority = $priority;
    }

    public function saveTask($userName)
    {
        $tasksJson = file_get_contents('../View/Task.json');
        $tasks = json_decode($tasksJson, true);
        $tasks[] = ['userName' => $userName, 'title' => $this->title, 'status' => $this->status, 'content' => $this->content, 'priority' => $this->priority, 'isCompleted' => $this->isCompleted];
        file_put_contents('../View/Task.json', json_encode($tasks));
        return 'Thêm công việc thành công';
    }
    public static function editTask($index, $newTitle = null, $newStatus = null, $newContent = null, $newPriority = null)
    {

        $tasksJson = file_get_contents('../View/Task.json');
        $tasks = json_decode($tasksJson, true);
        if (isset($tasks[$index])) {

            $tasks[$index] = [
                'userName' => $tasks[$index]['userName'],
                'title' => $newTitle ?? $tasks[$index]['title'],
                'status' => $newStatus ?? $tasks[$index]['status'],
                'content' => $newContent ?? $tasks[$index]['content'],
                'priority' => $newPriority ??  $tasks[$index]['priority'],
            ];
            file_put_contents('../View/Task.json', json_encode($tasks));

            return  "Cập nhập thành công";
        } else {
            return "Công việc không tồn tại";
        }
    }
    public static function deleteTask($index)
    {

        $tasksJson = file_get_contents('../View/Task.json');
        $tasks = json_decode($tasksJson, true);

        if (isset($tasks[$index])) {
            unset($tasks[$index]);
            $tasks = array_values($tasks);
            file_put_contents('../View/Task.json', json_encode($tasks));

            return 'Xóa công việc thành công';
        } else {
            return 'Công việc không tồn tại';
        }
    }
    public static function search($userName, $Title)
    {
        $tasksJson = file_get_contents('../View/Task.json');
        $tasks = json_decode($tasksJson, true);
        $userTasks = [];
        foreach ($tasks as  $task) {
            if (isset($task['userName']) && $task['userName'] == $userName  && $task['title'] == $Title) {
                $userTasks[] = $task;
            }
        }
        return $userTasks;
    }
    public static function filter($userName, $priority)
    {
        $tasksJson = file_get_contents('../View/Task.json');
        $tasks = json_decode($tasksJson, true);
        $userTasks = [];
        foreach ($tasks as  $task) {
            if (isset($task['userName']) && $task['userName'] == $userName  && $task['priority'] == $priority) {
                $userTasks[] = $task;
            }
        }
        return $userTasks;
    }
}
