# QubixQueries
Для чего: для замены запросов на выборку элементов в узких с точки зрения производительности местах

```php
$result = Query::getList(array( 
    'select' => array('ISBN', 'TITLE', 'PUBLISH_DATE') 
    'filter' => array('IBLOCK_ID' => 1, '=ID' => 1) 
)); 
// или
$q = new Query(); 
$q->setSelect(array('ISBN', 'TITLE', 'PUBLISH_DATE')); 
$q-setFilter(array('IBLOCK_ID' => 1, '=ID' => 1 )); 
$result = $q->exec();
```

<details>
  <summary>Если id инфоблока неизвестен</summary>
  
  Если id инфоблока неизвестен (или если фильтр добавляется динамически, например), можно указать имя класса (без метода getEntity()), но это +1 запрос к БД
  
 ```php
$result = Query::getList(array( 
    'select' => array('ISBN', 'TITLE', 'PUBLISH_DATE') 
    'filter' => array('=ID' => 1) 
),
	\ElementBookTable::class,
); 
// или
$q = new Query(\ElementBookTable::class); 
$q->setSelect(array('ISBN', 'TITLE', 'PUBLISH_DATE')); 
$q->setFilter(array('=ID' => 1)); 
$result = $q->exec();
```
</details>


