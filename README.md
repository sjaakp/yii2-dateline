YII2 Dateline
=============

#### Widget integrating my Dateline in Yii 2.0 PHP Framework. ####

Dateline widget renders my Javascript Dateline. The Event data for the dateline are provided by a Yii DataProvider (any object implementing [yii\data\DataProviderInterface](http://www.yiiframework.com/doc-2.0/yii-data-dataproviderinterface.html)).

A demonstration of Dateline widget is [here](http://www.sjaakpriester.nl/software/dateline).

## Installation ##

The preferred way to install **Dateline** is through [Composer](https://getcomposer.org/). Either add the following to the require section of your `composer.json` file:

`"sjaakp/yii2-dateline": "*"` 

Or run:

`$ php composer.phar require sjaakp/yii2-dateline "*"` 

You can manually install **Dateline** by [downloading the source in ZIP-format](https://github.com/sjaakp/yii2-dateline/archive/master.zip).

## Using Timeline ##


#### options ####

Dateline has the following options:

- **dataProvider**: the DataProvider for Timeline. Must be set.
- **attributes**: array with key => value pairs of {dateline attribute name} => {model attribute name}. This is used to 'translate' the model attribute names to Dateline attribute names. Required.
- **height**: height of Dateline. Default: 200. Can have these values:
 - `integer` height in pixels
 - `string` valid CSS height (f.i. in ems)
 - `false` height is not set; caution: the height MUST be set by some other means (CSS), otherwise Timeline will not appear.


- **htmlOptions** (optional): array of HTML options for the Dateline container. Use this if you want to explicitly set the ID. 

## Bands ##

**Timeline** consists of one or more Bands. They each display the Events in a different time resolution.

A Band is defined by the Dateline method `band()`.

    public function band( $options )

#### options ####

`$options` is an array with the following keys:

- **size**: the part of Dateline occupied by this band, as a percentage or another CSS3 dimension,
- **layout**: the only sensible value is 'overview'; all other values (including none) default to 'compact', which is the layout of the main band
- **scale**: the time unit that divides the horizontal scale of the Band. The value should be one of the following unit constants (yes, Dateline has an astonishing range!):
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
- **multiple** (optional): modifies the horizontal scale division to multiples of the unit 

## Events ##

**Dateline** displays Events: Models or ActiveRecords characterized by a moment in time.

The Dateline::attributes property holds the translation from Model attribute names to Dateline attribute names.
  
A few attributes are essential for **Dateline**. The Dateline names are:

- **start**: the point in time where the Event is situated
- **text**: the text displayed on main Dateline

Events come in two types:

#### Instant Events ####

These are the basic Events, having just one point in time. **Dateline** displays them as little pin icons. Only the above attributes are required.

#### Duration Events ####

These have a certain duration. **Dateline** displays them as a piece of blue 'tape'. Apart from the above, also required is:

- **end**: the point in time where, well, the Event ends.
   
Duration Events also have some optional attributes, making the Event *Imprecise*:


The imprecise part of a Duration Event is displayed as faded tape.

#### Optional Event attributes ####

Some of the other Event attributes are:

## Dates ##

**Dateline** understands a lot of date formats (in the options and in the Event data). Every date can be provided in one of the following formats:

- a `string`, recognized by [Javascript Date](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date), that is in RFC2822 or ISO-8601 format; among them MySQL `date` and `datetime` fields
- a PHP `DateTime` object
- an `array`, recognized by Javascript Date: `[ year, month, day?, hour?, minute?, second?, millisecond? ]`. Notice: month is zero-based, so January == 0, May == 4
- an `integer`: Unix time stamp (seconds since the Unix Epoch, 1-1-1970, return value of PHP `time()`)
