# Generate Chinese ID Number

## Installation
### composer
```
composer require archerzdip/chinese-idnumber-generate
```

### Laravel
In your config/app.php add ArcherZdip\GenerateIDNumber\GenerateChineseIDNumberServiceProvider::class, to the end of the providers array:
```php
'providers' => [
    ...
    ArcherZdip\GenerateIDNumber\GenerateChineseIDNumberServiceProvider::class,
],
```


## Methods
* get()
* getone()
* on(array $attributes)
* limit(int $count)
* toString()
* toArray()

## Usage

### **getOne() usage:**
```php
$idNo = app('chinese_id_faker')->on([
    'province' => '辽宁省',
    'city'    => '', // random
    'region'    => '', // random
    'datetime' => '', // random
    'sex'      => 0,  // 0-male  1-female
])->getOne();
dd($idNo);    
```
**Result is object:**
```
ArcherZdip\GenerateIDNumber\ChineseIDNumber {#266
  +id: "210422201802123855"
  +province: "辽宁省"
  +city: "抚顺市"
  +region: "新宾满族自治县"
  +sex: "男"
  +birth: "20180212"
}
```

### **get() usage"**
```php
$idNos = app('chinese_id_faker')->on([
    'province' => '辽宁省',
    'city'    => '',
    'region'    => '',
    'datetime' => '',
    'sex'      => 1,  // 0-male  1-female
])->limit(1)->get();
dd($idNos);
```
**Result is object:**
```
ArcherZdip\GenerateIDNumber\Foo {#267
  +items: array:1 [
    0 => ArcherZdip\GenerateIDNumber\ChineseIDNumber {#266
      +id: "511825197911085740"
      +province: "四川省"
      +city: "雅安市"
      +region: "天全县"
      +sex: "女"
      +birth: "19791108"
    }
  ]
}

```

### **On(array $attributes) usage:**
$attributes is arguments,including:
- province: Chinese province
- city: city, like `沈阳市`
- region: region, like `某某区`
- datetime: Birthdate, format is 2018-08-08
- sex: Sex, 0 is male and 1 is female

### **limit(int $count) usage:**
Limit the number of rows you can get.

### **toString() usage:**
Just show chinese id number.
```$xslt
"211201201802129542"
```
or:
```$xslt
array:2 [
  0 => "63212619971109033X"
  1 => "810000195308134165"
]
```

### **toArray() usage:**
Object to array.
Like:
```
array:6 [
  "id" => "211201201802129542"
  "province" => "辽宁省"
  "city" => "铁岭市"
  "region" => "市辖区"
  "sex" => "女"
  "birth" => "20180212"
]
```