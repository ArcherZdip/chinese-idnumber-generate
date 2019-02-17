# Generate Chinese ID Number

## Installation
### composer

### Laravel
In your config/app.php add ArcherZdip\GenerateIDNumber\GenerateChineseIDNumberServiceProvider::class, to the end of the providers array:
```php
'providers' => [
    ...
    ArcherZdip\GenerateIDNumber\GenerateChineseIDNumberServiceProvider::class,
],
```
In your config/app.php add 'GenerateIDNo' => \ArcherZdip\GenerateIDNumber\GenerateChineseIDNumberFacade::class, to the end of the aliases array:
```php
'aliases' => [
    ...
    'GenerateIDNo' => \ArcherZdip\GenerateIDNumber\GenerateChineseIDNumberFacade::class,
],
```

## Methods
* get()
* getone()
* on(array $attributes)
* limit(int $count)

## Usage

**Getone() usage:**
```php
    $idNo = app('generate_ch_id')->on([
        'province' => '辽宁省',
        'city1'    => '', // random
        'city2'    => '', // random
        'datetime' => '', // random
        'sex'      => 1,  // 0-male  1-female
        'info'     => 1,  // 1 show all info
    ])->getone();
    dd($idNo);    
```
**Result is array:**
```
array:6 [▼
  "id" => "21038119970424464x"
  "province" => "辽宁省"
  "city1" => "鞍山市"
  "city2" => "海城市"
  "sex" => "女"
  "borth" => "19970424"
]
```
**If info is 0, result is string:**
```
"210303199909245583"
```

**get() usage"**
```php
    $idNos = app('generate_ch_id')->on([
        'province' => '辽宁省',
        'city1'    => '',
        'city2'    => '',
        'datetime' => '',
        'sex'      => 1,  // 0-male  1-female
        'info'     => 1,  // 1 show all info
    ])->limit(5)->get();
    dd($idNos);
```
**Result is array:**
```
array:5 [▼
  0 => array:6 [▼
    "id" => "210803196901303869"
    "province" => "辽宁省"
    "city1" => "营口市"
    "city2" => "西市区"
    "sex" => "女"
    "borth" => "19690130"
  ]
  1 => array:6 [▼
    "id" => "21100220061113944x"
    "province" => "辽宁省"
    "city1" => "辽阳市"
    "city2" => "白塔区"
    "sex" => "女"
    "borth" => "20061113"
  ]
  2 => array:6 [▶]
  3 => array:6 [▶]
  4 => array:6 [▶]
]
```
**If info is 0, result is array:**
```
array:5 [▼
  0 => "211404197304158122"
  1 => "211100197901168327"
  2 => "211102195811081387"
  3 => "211302200607283189"
  4 => "210111198904302926"
]
```

**On(array $attributes) usage:**
$attributes is arguments,including:
- province: Chinese province
- city1: The first level city, like `沈阳市`
- city2: The second level city, like `某某区`
- datetime: Birthdate, format is 2018-08-08
- sex: Sex, 0 is male and 1 is female
- info: Is show all info

**limit(int $count) usage:**
Limit the number of rows you can get.