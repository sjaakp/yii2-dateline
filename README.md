Yii2 Dateline
=============

#### Widget for date-related data in Yii 2.0 PHP Framework. ####

[![Latest Stable Version](https://poser.pugx.org/sjaakp/yii2-dateline/v/stable)](https://packagist.org/packages/sjaakp/yii2-dateline)
[![Total Downloads](https://poser.pugx.org/sjaakp/yii2-dateline/downloads)](https://packagist.org/packages/sjaakp/yii2-dateline)
[![License](https://poser.pugx.org/sjaakp/yii2-dateline/license)](https://packagist.org/packages/sjaakp/yii2-dateline)

Dateline widget renders my [JavaScript Dateline](https://github.com/sjaakp/dateline). 
The event data for the dateline are provided by a Yii DataProvider 
(any object implementing [yii\data\DataProviderInterface](http://www.yiiframework.com/doc-2.0/yii-data-dataproviderinterface.html)).

A demonstration of Dateline widget is [here](https://sjaakpriester.nl/software/dateline2).

See it in action at [Moordatlas.nl](https://moordatlas.nl/event/dateline) (Dutch).
At *Weltliteratur* is a [nice example](https://vossanto.weltliteratur.net/timeline/) of the
underlying JavaScript widget.

## Installation ##

Install **Dateline** with [Composer](https://getcomposer.org/). Either add the following to the require section of your `composer.json` file:

`"sjaakp/yii2-dateline": "*"` 

Or run:

`composer require sjaakp/yii2-dateline "*"` 

You can manually install **Dateline** by [downloading the source in ZIP-format](https://github.com/sjaakp/yii2-dateline/archive/master.zip).

## Using Dateline ##

**Yii2-dateline** implements a widget of the class `Dateline`. 
It gets its data from an `ActiveDataProvider`, `ArrayDataProvider`, 
or other class derived from [`BaseDataProvider`](https://yiiframework.com/doc-2.0/yii-data-basedataprovider.html "Yii") Using it is not unlike using a [GridView](http://www.yiiframework.com/doc-2.0/yii-grid-gridview.html "Yii Framework").
For instance, in the Controller you might have something like:

	<?php
	// ...
	public function actionFoo()	{
		$dataProvider = new ActiveDataProvider([
			'query' => InterestingEvent::find(),
		    'pagination' => false
		]);
		
		return $this->render('foo', [
			'dataProvider' => $dataProvider
		]);
	}
	// ...
	?>

An example of rendering a `Dateline` in the `View` is:

	use sjaakp\dateline\Dateline;

	/* ... */
	
	<?php $dl = Dateline::begin([
	    'dataProvider' => $dataProvider,
	    'attributes' => [
	        'id' => 'id',
	        'start' => 'date1',
	        'text' => 'name'
	    ],
	    'options' => [
			/* ... */
	    ]
	]);
	
	$dl->band([
        'size' => '75%',
	    'scale' => Dateline::WEEK,
	    'interval'=> 90,
	])
	  ->band([
        'size' => '25%',
        'layout' => 'overview',
        'scale' => Dateline::YEAR,
        'interval'=> 80
    ]);
	
	Dateline::end();
	?>


#### options ####

Dateline has the following options:

- **dataProvider**: the DataProvider for Dateline. Must be set.
- **attributes**: used to 'translate' the model attributes to Dateline attributes.
   It is an array with key => value pairs of:
    - {dateline attribute name} => {model attribute name}.
    - {dateline attribute name} => `function($model)` returning {model attribute value}.
- **options**: array of options for the underlying Dateline jQuery widget. More information [here](https://github.com/sjaakp/dateline#cursor "GitHub").
- **htmlOptions** (optional): array of HTML options for the Dateline container. Use this if you want to explicitly set the ID. 

## Bands ##

**Dateline** consists of one or more Bands. They each display the Events 
in a different time resolution.

A Band is defined by the Dateline method `band()`.

    public function band( $options )

#### options ####

`$options` is an array with the following keys:

- **size**: the part of Dateline occupied by this band, as a percentage or another CSS3 dimension,
- **layout**: the only sensible value is `'overview'`; all other values (including none) default to `'normal'`, which is the layout of the main band
- **scale**: the time unit that divides the horizontal scale of the Band. The value should be 
one of the following unit constants (yes, Dateline has an astonishing range!):
	- `Dateline::MILLISECOND`
	- `Dateline::SECOND`
	- `Dateline::MINUTE`
	- `Dateline::HOUR`
	- `Dateline::DAY`
	- `Dateline::WEEK`
	- `Dateline::MONTH`
	- `Dateline::YEAR`
	- `Dateline::DECADE`
	- `Dateline::CENTURY`
	- `Dateline::MILLENNIUM`
- **interval**: the width of one division on the horizontal scale in pixels
- **multiple** (optional): modifies the horizontal scale division to multiples of 
the unit 

## Events ##

*Note that we're not talking about PHP or JavaScript events here!*

**Dateline** displays Events. These are Models or ActiveRecords characterized 
by a moment in time.

The Dateline::attributes property holds the translation from Model attributes 
to Dateline attributes.
  
A few attributes are essential for **Dateline**. The Dateline names are:

- **start**: the point in time where the Event is situated
- **text**: the text (or HTML) displayed on the main Dateline

Events come in two types:

#### Instant Events ####

These are the basic Events, having just one point in time. **Dateline** displays 
them as dot icons. Only the above attributes are required.

#### Duration Events ####

These have a certain duration. **Dateline** displays them as a piece of 'tape'. 
Apart from the above, also required is:

- **stop**: the point in time where, well, the Event ends.
   
Duration Events also have some optional attributes, making the Event *imprecise*:

- **post_start**: *optional*. Indicates a degree of uncertainty in `start`.

- **pre_stop**: *optional*. Indicates a degree of uncertainty in `stop`.

The imprecise part of a Duration Event is displayed as faded tape.

#### Optional Event attribute ####

- **class**: sets the HTML class(es) of the event in normal layout. 
Can be used to iconize or colorize an event. For more information, 
see [https://github.com/sjaakp/dateline#iconizing-events](https://github.com/sjaakp/dateline#iconizing-events "jQuery.dateline")

## Dates ##

**Dateline** understands a lot of date formats (in the options and in the Event data).
Every date can be provided in one of the following formats:

- a `string`, recognized by [JavaScript Date](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date),
 that is in RFC2822 or ISO-8601 format; among them MySQL `date` and `datetime` fields
- an `integer`: Unix time stamp (seconds since the Unix Epoch, 1-1-1970,
 return value of PHP `time()`)
