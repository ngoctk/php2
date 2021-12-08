<?php
require_once './Category.php';
$cates = Category::all();

// echo "<pre>";
// var_dump($cates);
// die;

?>
<table>
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>
            <a href="add-new.php">Tạo mới</a>
        </th>
    </thead>
    <tbody>
    <?php foreach($cates as $c): ?>
        <tr>
            <td><?= $c->id ?></td>
            <td><?= $c->cate_name ?></td>
            <td>
                <a href="edit.php?id=<?= $c->id ?>">Sửa</a>
                <a href="remove.php?id=<?= $c->id ?>">Xóa</a>
            </td>
        </tr>
    <?php endforeach?>
    </tbody>
</table>