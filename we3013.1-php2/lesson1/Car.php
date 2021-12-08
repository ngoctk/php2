<?php
class car{
    var $id;
    var $model;
    var $color;
    var $year;
    var $warranty;
    var $brand;
    var $owner;

    function buy_car($id, $model, $color, $brand, $owner){
        $this->id = $id;
        $this->model = $model;
        $this->color = $color;
        $this->year = date("d/m/Y");
        $this->warranty = rand(3, 5);
        $this->brand = $brand;
        $this->owner = $owner;
    }

    function sell_car($newOwner, $usingYear){
        $HSD = $this->warranty - $usingYear;
        ($HSD > 0) ? $this->warranty = $HSD : $this->warranty = 0;
        $this->owner = $newOwner;
    }
}
$bmw = new car();
$bmw->buy_car("1"," thể thao", "đỏ", "bmw","ngọc");
$bmw->sell_car("c", 3);

$b = new car();
$b->buy_car("3","xxx", "trắng", "b","ngoc");
$b->sell_car("v",5 );

$arr = [$bmw, $b];
?>
<table>
<thead>
    <th>Mã xe</th>
    <th>Dòng xe</th>
    <th>Màu sắc</th>
    <th>Năm sản xuất</th>
    <th>Số năm bảo hành</th>
    <th>Hãng xe</th>
    <th>Chủ sở hữu</th>
</thead>
<tbody>
<?php foreach ($arr as $item): ?>
    <tr>
        <td><?= $item->id ?></td>
        <td><?= $item->model ?></td>
        <td><?= $item->color ?></td>
        <td><?= $item->year ?></td>
        <td><?= $item->warranty ?></td>
        <td><?= $item->brand ?></td>
        <td><?= $item->owner ?></td>
    </tr>
<?php endforeach?>
</tbody>
</table>