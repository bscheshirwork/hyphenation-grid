hyphenation-grid
========================

Данные одной сущности размещаем в несколько строк для zii.widgets.grid.CGridView

Использование:

Импортируем компонент:

```php
<?php Yii::import('vendor.bscheshir.hyphenation-grid.HypGridView', true); ?>
```

В свойствах добавлены следующие настройки: 

'hyphenationColumns' = array();
массив номеров колонок, по которым осуществлять перенос на новую строку
или 

'hyphenationOnCount' = null;
через каждые N колонок делать перенос

Используем colspan для объеденения колонок.
В остальном - используем как обычно. 

Пример
```php
...
$controller = $this;
...
<?php $this->widget('HypGridView', [
	'id'=>'currencyrate-grid-1',
	'dataProvider'=>$dataProvider,
	'hyphenationColumns'=>[2,3],
	//'hyphenationOnCount'=>2,
	'columns'=>[
		'ccy',
		'ccy_name_ru',
		[
			'name'=>'buy',
			'type' => 'raw',
			'value'=>'$data->buy/10000',
			'headerHtmlOptions'=>['colspan'=>'2'],
			'htmlOptions'=>['colspan'=>'2'],
		],
		[
			'name'=>'sortOrder',
			'evaluateHtmlOptions'=>true,
			'htmlOptions'=>['id'=>'"ordering_{$data->id}"'],		
		],
		'unit',
		'date',
		[
			'name'=>'somename',
			'header'=>'someheader',
			'value' => function($data, $row) use ($controller) {
				return $controller->renderPartial('trait/__someone', array('data' => $data), true);
			},		  
		],
	],
]); ?>
```
