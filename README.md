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


'hyphenationRowHtmlOptionsExpression' 
аналог rowHtmlOptionsExpression, применяется к <tr> перенесённой строке. Если передан hyphenationOnCount - берётся для каждого переноса. Иначе требуется передать массив, где ключами будут номера колонок, по которым идёт перенос,
а значениями - применяемые для этого переноса опции.


'hyphenationRowCssClassExpression'
аналог rowCssClassExpression, применяется к <tr> перенесённой строке. Если передан hyphenationOnCount - берётся для каждого переноса. Иначе требуется передать массив, где ключами будут номера колонок, по которым идёт перенос,
а значениями - применяемые для этого переноса опции.


'hyphenationDisableRowCssClass'
Если данный флаг передан - для новой строки не будет применятся стиль из перечесления rowCssClass.
Работает в паре с 'hyphenationRewriteClass'
По умолчанию true

'hyphenationRewriteClass'
При переносе строки перезаписывать класс, сформированный для начала строки. Новые значения, вычисленные в
hyphenationRowHtmlOptionsExpression и hyphenationRowCssClassExpression заменят $htmlOptions['class'] начала строки.
Используйте с 'hyphenationDisableRowCssClass'=>false, если всё ещё хотите применить тот же стиль из перечисления rowCssClass, что и в начале строки.
По умолчанию false


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
	'hyphenationRowHtmlOptionsExpression'=>[
		2=>['id'=>'"second_{$data->id}"']
	],
	'hyphenationRowCssClassExpression'=>[
		2=>['display'=>'none']
	],
	'hyphenationDisableRowCssClass'=>true,
	'hyphenationRewriteClass'=>false,
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
