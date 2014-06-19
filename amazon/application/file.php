<?php
 
// Объект предоставляющий методы для работы БД
// например объект класса PDO
$pdo      = new PDO('mysql:dbname=... ;');
 
// Результирующий массив с элементами, выбранными с учётом LIMIT:
$items    = array();
 
// Число вообще всех элементов ( без LIMIT ) по нужным критериям.
$allItems = 0;
 
// HTML - код постраничной навигации.
$html     = NULL;
 
// Количество элементов на странице. 
// В системе оно может определяться например конфигурацией пользователя: 
$limit    = 7;
 
// Количество страничек, нужное для отображения полученного числа элементов:
$pageCount = 0;
 
// Содержит наш GET-параметр из строки запроса. 
// У первой страницы его не будет, и нужно будет вместо него подставить 0!!!
$start    = isset($_GET['start'])   ? intval( $_GET['start'] )   : 0 ;
 
// Некий критерий выборки - показан для естественности примера 
// В реальности может быть идентификатором какой нибудь категории:
$critery  = isset($_GET['critery']) ? intval( $_GET['critery'] ) : 0 ;
 
// Запрос для выборки целевых элементов:
$sql = 'SELECT           ' . 
       '  `table_name`.* ' . 
       'FROM             ' .
       '  `table_name`   ' .
       'WHERE            ' .
       '  `critery` =    ' . $critery . ' ' .
       'LIMIT            ' . 
           $start . ',   ' . $limit   . ' ' .
       'ORDER BY         ' . 
       '  `critery`      ';
            
$stmt  = $pdo->query($sql);
$items = $stmt->fetchAll(PDO::FETCH_OBJ);
 
if( is_array($items) ) {
     
    foreach( $items AS $item ) {
         
        // ... ЗДЕСЬ КОД ФОРМИРУЮЩИЙ ВЫВОД ЭЛЕМЕНТОВ ...
         
    }
     
}
 
// СОБСТВЕННО, ПОСТРАНИЧНАЯ НАВИГАЦИЯ:          
// Получаем количество всех элементов:
$sql = 'SELECT         ' . 
       '  COUNT(*) AS `count` ' . 
       'FROM           ' .
       '  `table_name` ' .
       'WHERE          ' .
       '  `critery` =  ' . $critery;
 
$stmt     = $pdo->query($sql);
$allItems = $stmt->fetch(PDO::FETCH_OBJ)->count;
 
// Здесь округляем в большую сторону, потому что остаток
// от деления - кол-во страниц тоже нужно будет показать
// на ещё одной странице.
$pageCount = ceil( $allItems / $limit);
 
// Начинаем с нуля! Это даст нам правильные смещения для БД
for( $i = 0; $i < $pageCount; $i++ ) {    
    // Здесь ($i * $limit) - вычисляет нужное для каждой страницы  смещение, 
    // а ($i + 1) - для того что бы нумерация страниц начиналась с 1, а не с 0
    $html .= '<li><a href="index.php?category=' . $critery . '&start=' . ($i * $limit)  . '">' . ($i + 1)  . '</a></li>';
}
 
// Собственно выводим на экран:
echo '<ul class="pagination">' . $html . '</ul>'; 





function get_rows_count($data_tab){

	$sql="SELECT 
	COUNT(*)
	FROM 
				jobs,
				users,
				user_country,
				user_int_industry
	WHERE
	users.id=:id AND (
			
					users.consideration_id=jobs.level_role_id OR
					users.function_id=jobs.function_id OR
					users.salary=jobs.salary OR
					users.years_exp_id=jobs.exp_years_id
					
					)OR
				
				(user_country.id_country=jobs.role_loc_id AND
				user_country.id_user=users.id 
				)OR
				
				(user_int_industry.id_int_industry=jobs.id_industry AND
				 user_int_industry.id_user=users.id
				
				) 
				 LIMIT 20000";

	$res = $this->registry['wdb']->query($sql);
	return $res->fetchColumn();

}

function limit_where($count,$current_page=1){

	$quant_list=10;
	//$quant_list=$data_tab['collection'][0]['quant_list'];
	//if($quant_list==0){$quant_list=10;}
		
		
		$num_pages = ceil($count / $quant_list);

		//$current_page = isset($param['page']) ? (int)$param['page'] : 1;

if($current_page > $num_pages){
	$current_page = $num_pages;
}
	$start_from = ($current_page - 1) * $quant_list;

	$limit=" LIMIT $start_from, $quant_list";

	return array('num_pages'=>$num_pages, 'current_page'=>$current_page, 'limit'=>$limit);
//return $limit_where;

}











?>