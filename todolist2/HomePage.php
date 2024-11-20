<?php
session_start();
if (!$_SESSION['userName']) {
    header("Location: Index.php");
}
$userName = $_SESSION['userName'];
require_once 'TodoList.php';
$reslutSearch = null;
$reslutFilter = null;
$errMess = '';

use TODOLIST\todolist1\TodoList;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST["indexUpdate"])) {
        $respone = TodoList::editTask(
            $_POST["indexUpdate"],
            trim($_POST["title"]),
            trim($_POST["status"]),
            trim($_POST["content"]),
            trim($_POST["priority"])
        );

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else if (isset($_POST['indexDelete'])) {
        $respone =  TodoList::removeTask($_POST['indexDelete']);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['addTask'])) {
        $title = isset($_POST["title"]) ? trim($_POST["title"]) : null;

        $content = isset($_POST["content"]) ? trim($_POST["content"]) : null;
        $priority = isset($_POST["priority"]) ? trim($_POST["priority"]) : null;

        if (empty($title)  || empty($content) || empty($priority)) {
            $errMess = "Thiếu dữ liệu! Vui lòng nhập đầy đủ.";
        } else {

            TodoList::addTask($userName, $title, $content, $priority);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    } elseif (isset($_POST['search'])) {
        $reslutSearch = TodoList::search($userName, $_POST['search']);
    } elseif (isset($_POST['filter'])) {
        $reslutFilter = TodoList::filter($userName, $_POST['filter']);
    } elseif (isset($_POST['listIndexToUpdate'])) {
        $listIndex = json_decode($_POST['listIndexToUpdate']);
        if (!empty($listIndex)) {
            foreach ($listIndex as  $value) {
                TodoList::editTask($value, null, 'completed');
            }
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['logOut'])) {
        session_destroy();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    echo "<p> Xin Chào  $userName </p>";
    ?>
    <form action="" method="POST">
        <input style="display: none;" type="text" name="logOut" value="1">
        <input type="submit" value="Đăng xuất">
    </form>

    <?php
    $tasks = TodoList::getTasks($_SESSION['userName']);
    if (!empty($tasks)) {
        echo '  <h2 > danh sách công việc</h2>';
        echo  '<div style="display: flex;" class="listWork" >';
        foreach ($tasks as $index => $task) {
            echo '
        <div data-index=' . $index . ' style="padding-left: 10px;" class="task-item" indexIndata=' . $task['indexIndata'] . '>
        <h3>Title: ' . $task['title'] . '</h3>
        <p>Status: ' . $task['status'] . '</p>
        <p>Content: ' . $task['content'] . '</p>
        <p>priority: ' . $task['priority'] . '</p>
        <input class="checkComplete" type="checkbox" id="checkbox1" name="isCompleted" data-index=' . $index . '>
        <label >Đã hoàn thành</label>
        <div style="display: flex;" class="">
        <button class="editButton" data-index=' . $index . ' >Sửa</button>
        <form action="" method="POST">
        <input style="display: none;"  name="indexDelete"   value="' . $task['indexIndata'] . '"/> 
        <input type="submit" value="Xóa"/>
        </form>
        </div>
       
        <div style="display: flex;" class="">
       
        <form action="" method="POST" data-index=' . $index . ' class="editForm" style="display: none; margin-top: 10px;">
        <input name="title"  type="text" value="' . $task['title'] . '"  />
        <select name="status" id="example">
        <option value="incomplete">incomplete</option>
        <option value="completed">completed</option>
    </select>
        <input name="content"   value="' . $task['content'] . '"/> 
        <select name="priority" id="example">
        <option value="low">low</option>
        <option value="medium">medium</option>
        <option value="hard">hard</option>

    </select>

        <input style="display: none;"  name="indexUpdate"   value="' . $task['indexIndata'] . '"/> 
        <div style="display: flex;" class="">
        <button type="submit"  >Lưu</button>
        <button data-index=' . $index . ' class="exitForm" >Hủy</button>
        </div>
       
    </form>
        </div>

      </div>';
        }
        echo '</div>';
    } else {
        echo "<h2> Danh sách công việc </h2>";
    }
    ?>
    <div class="">
        <form style="padding: 10px;" action="" method="POST">
            <input name="listIndexToUpdate" class="listToUpdate" style="display: none;">

            <input type="submit" value="cập nhập trạng thái">
        </form>
    </div>
    <div style="display: block;" class="">
        <div class="">
            <form style="padding: 1px;" action="" method="POST">
                <h2> Search theo title </h2>
                <input type="text" name="search">
                <input type="submit" value="tìm kiếm">
            </form>
            <?php echo '<ul>';
            if ($reslutSearch) {
                foreach ($reslutSearch as $task) {
                    echo '<li>';
                    echo 'Title: ' . htmlspecialchars($task['title']) . ', ';
                    echo 'Status: ' . htmlspecialchars($task['status']) . ', ';
                    echo 'Content: ' . htmlspecialchars($task['content']) . ', ';
                    echo 'Priority: ' . htmlspecialchars($task['priority']);
                    echo '</li>';
                }
            }


            echo '</ul>'; ?>
        </div>
        <div class="">
            <form action="" method="POST">
                <h2> Filter theo mức độ ưu tiên</h2>
                <select name="filter" id="">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="hard">ard</option>

                </select>

                <input type="submit" value="Lọc">
            </form>
            <?php echo '<ul>';
            if ($reslutFilter) {
                foreach ($reslutFilter as $task) {
                    echo '<li>';
                    echo 'Title: ' . htmlspecialchars($task['title']) . ', ';
                    echo 'Status: ' . htmlspecialchars($task['status']) . ', ';
                    echo 'Content: ' . htmlspecialchars($task['content']) . ', ';
                    echo 'Priority: ' . htmlspecialchars($task['priority']);
                    echo '</li>';
                }
            }


            echo '</ul>'; ?>
        </div>
        <div class="">
        <form action="" method="POST">
                <h2> Thêm công việc </h2>
                <div class="">
                    <label for="">title</label>
                    <input style="display: flex;" type="text" name="title">
                </div>
                <div class="">
                    <label for="">content</label>
                    <input style="display: flex"; type="text" name="content">
                </div>
                <input type="text" style="display: none;" name="addTask">
                <div class="">
                    <label for="">priority</label>
                    <select name="priority" id="example">
                        <option value="low">low</option>
                        <option value="medium">medium</option>
                        <option value="hard">hard</option>

                    </select>
                </div>
                <input type="submit" value="thêm">
            </form>

        
            <?php echo "<p>$errMess</p>" ?>
        </div>

    </div>




</body>
<script>
    const editForms = document.querySelectorAll('.editForm')
    const editButtons = document.querySelectorAll('.editButton')
    const exitButtons = document.querySelectorAll('.exitForm')
    const checkComplete = document.querySelectorAll('.checkComplete')
    const taskTtems = document.querySelectorAll('.task-item')
    const listIndexToUpdates = document.querySelector('.listToUpdate')
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {

            const index = button.getAttribute('data-index');

            editForms[index].style.display = 'flex';
            editForms[index].style.flexDirection = 'column';
        });
    });


    exitButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const index = button.getAttribute('data-index');
            editForms[index].style.display = 'none';
        });
    });
    let indexIndatas = [];
    checkComplete.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const index = checkbox.getAttribute('data-index');
            if (checkbox.checked) {
                indexIndatas.push(taskTtems[index].getAttribute('indexIndata'));
                listIndexToUpdates.value = JSON.stringify(indexIndatas);
                console.log(listIndexToUpdates);
                taskTtems[index].style.textDecoration = 'line-through';
                taskTtems[index].style.opacity = '0.5';
                taskTtems[index].style.fontStyle = 'italic';
            } else {

                taskTtems[index].style.textDecoration = 'none';
                taskTtems[index].style.opacity = '1';
                taskTtems[index].style.fontStyle = 'normal';
            }
        })
    })
</script>

</html>