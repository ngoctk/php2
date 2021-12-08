<?php 
	
	class BaseModel 
	{
		
		protected function getConnect() //dùng để kết nối tới cơ sở dữ liệu
		{
	        $conn = new PDO('mysql:host=127.0.0.1;dbname=kaopiz;charset=utf8', 'root', '12345678');
	        return $conn;
	    }
	    
		public function insert($arr){ // dùng insert dữ liệu vào trong bảng của database
			$this->queryBuilder = "insert into $this->tableName ";//insert đến bảng mà có class kế thừa basemodel
			$cols = " (";
			$vals = " (";
			foreach ($arr as $key => $value) { //lặp tham số $arr được truyền khi thực hiện lệnh insert 
				$cols .= " $key,";//tên cột trong bảng
				$vals .= " :$key,";// tham số ẩn danh
			}
			$cols = rtrim($cols, ','); // loại bỏ khoảng trắng và dấu , cuối chuỗi
			$vals = rtrim($vals, ',');
			$cols .= ") ";
			$vals .= ") ";
			$this->queryBuilder .= $cols . ' values ' . $vals; //hoàn thiện câu lệnh truy vấn insert
			$stmt = $this->getConnect()
						->prepare($this->queryBuilder);//kết nối cơ sở dữ liệu và tạo ra đối tượng prepare
			foreach ($arr as $key => &$value) {
				$stmt->bindParam(":$key", $value);
			}// lặp tham số $arr được truyền khi thực hiện lệnh insert gắn value vào các tham số ẩn danh theo thứ tự tương ứng
			// var_dump($this->queryBuilder);die;
			$stmt->execute(); //thực thi câu lệnh
		}
		public function update($arr){// dung để update dữ liêu cho cột trong bảng theo id
			$this->queryBuilder = "update $this->tableName set "; update đến bảng mà có class kế thừa basemodel
			
			foreach ($arr as $key => $value) { //lặp tham số $arr được truyền khi thực hiện lệnh update
				$this->queryBuilder .= " $key = :$key,"; //vidu (name = :name) :name là tham số ẩn danh
			}
			$this->queryBuilder = rtrim($this->queryBuilder, ','); // loại bỏ khoảng trắng và dấu , cuối chuỗi
			$this->queryBuilder .= " where id = :id;//truyền tham số ẩn danh cho id
			$stmt = $this->getConnect()
						->prepare($this->queryBuilder);
			foreach ($arr as $key => &$value) {
				$stmt->bindParam(":$key", $value);
			}
			$stmt->bindParam(":id", $this->id);//gán giá trị id cho tham số ẩn danh 
			$stmt->execute();
		}
		public static function rawQuery($sqlQuery){//để chạy các câu lệnh được truyền vào
			$model = new static();//tạo ra đối tượng static để truy cập vào các thuộc tính hay phương thức trong class
			$model->queryBuilder = $sqlQuery;
			return $model;
		}
	
		public function orderBy($col, $asc = true){//sắp xếp dữ liệu
//$asc sẽ mặc định là true nếu k truyền gì vào 
//$col là giá trị được truyền vào để sắp xếp theo thứ tự desc hoặc asc ví dụ như name , id
			$this->queryBuilder .= " order by $col";
			$this->queryBuilder .= $asc == true ? " asc " : " desc ";//nếu $asc == true thì giá trị của thì giá trị của $asc là asc còn ngược lại là desc 
// order by name asc ($col = name và $asc == true)
			return $this;
		}
	
		public static function sttOrderBy($col, $asc = true){
			$model =  new static();
			$model->queryBuilder = "select * from $model->tableName order by $col";
			$model->queryBuilder .= $asc == true ? " asc " : " desc ";
			
			return $model;
		}
	
		public function limit($take, $skip = false){//giới hạn số bản ghi
			$this->queryBuilder .= " limit $take";//$take là số bản ghi được truyền vào
			if($skip != false){//nếu khác false thì số bản ghi sẽ giá trị của $take ,$skip vidu limit 3,5($take = 3 , $skip = 5) tức là sẽ lấy ra 5 bản ghi tính từ bản ghi thứ 3 trở lên
				$this->queryBuilder .= ", $skip";
			}
//nếu không thì skip == false thì vidu limit 3 sẽ lấy 3 bản ghi đầu tiên
	
			return $this;
		}
	
	
		public function execute(){//thực thi câu lệnh sql
			$stmt = $this->getConnect()->prepare($this->queryBuilder);
			return $stmt->execute();
		}
		public static function all(){//lấy tất cả bản ghi trong 1 bảng
			$model = new static();
	        $query = "select * from $model->tableName";
	        $stmt = $model->getConnect()->prepare($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_CLASS, get_class($model));
	 	}
	 	public static function where($arr){//tìm kiếm bản ghi thỏa mãn điểu kiện với 3 tham số trong mảng vidu như $arr được truyền $arr = [‘name’,’like’,’ngọc’]
thì câu lệnh sẽ là select * from User(tên bảng) where name like ‘ngọc’;
	 		$model = new static();//tạo ra đối tượng static để truy cập vào các thuộc tính hay phương thức trong class và class kế thừa
	 		$model->queryBuilder = "select * from $model->tableName where $arr[0] $arr[1] '$arr[2]'";
	
	 		return $model;
	 	}
	
	 	public static function destroy($id){//xóa bản ghi theo id
	 		$model = new static();
	 		$model->queryBuilder = "delete from $model->tableName
	 								where id = $id";
	
			return $model->execute();
		}
	
	 	public function andWhere($arr){//2 điều kiện trong câu sql
	 		$this->queryBuilder .= " and $arr[0] $arr[1] '$arr[2]'";
	 		return $this;
	 	}
	 	public function orWhere($arr){//câu điều kiện hoặc trong sql
	 		$this->queryBuilder .= " or $arr[0] $arr[1] '$arr[2]'";
	 		return $this;
	 	}
	 	public function first(){//tìm ra tất cả các bản ghi thỏa mãn
	
	 		$stmt = $this->getConnect()->prepare($this->queryBuilder);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
	
			if(count($result) > 0){
				return $result[0];
			}else{
				return null;
			}
	 	}
	 	public function get(){//tìm ra tất cả các bản ghi thỏa mãn
	 		$stmt = $this->getConnect()->prepare($this->queryBuilder);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
			
			return $result;
	 	}
	}
	
	
	 ?>

