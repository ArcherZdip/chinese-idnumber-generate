<?php
/**
 * Created by PhpStorm.
 * User: zhanglingyu
 * Date: 2019-02-15
 * Time: 18:18
 */

namespace ArcherZdip\GenerateIDNumber;


class GenerateChineseIDNumberService
{
    /** @var $province */
    public $province = null;

    /** @var $city1 first level city */
    public $city1 = null;

    /** @var $city2 second level city */
    public $city2 = null;

    /** @var $cityid */
    public $cityid = null;

    /** @var $datetime */
    public $datetime = null;

    /** @var $sex */
    public $sex = null;

    /** @var int $limit */
    public $limit = 1;

    /** @var array $citys */
    public $citys = [];

    /** @var array $provinces */
    public $provinces = [];

    /** @var array $cityInfo */
    public $cityInfo = [];

    /** @var bool $info is show all info */
    public $info = false;

    /** @var array $fillable set param */
    protected $fillable = ['province', 'city1', 'city2', 'datetime', 'sex', 'info'];

    /** @var int 男 */
    const MALE = 0;

    /** @var int 女 */
    const FEMALE = 1;

    /** @var int province num in china */
    const PROVINCENUM = 34;

    /** @var int max limit */
    const MAXCOUNT = 100;

    /**
     * GenerateChineseIDNumberService constructor.
     */
    public function __construct()
    {
    }

    /**
     * Generate multi chinese id number
     * @return array
     * @throws \Exception
     */
    public function get()
    {
        $ids = [];
        for ($i = 0; $i < $this->limit; $i++) {
            $ids[] = $this->generateChineseID();
        }

        return $ids;
    }

    /**
     * Generate one chinese id number
     * @return string
     * @throws \Exception
     */
    public function getone()
    {
        return $this->generateChineseID();
    }

    /**
     * set attributes for generate chinese id number.
     * @param array $attributes
     * @return GenerateChineseIDNumberService
     */
    public function on(array $attributes = [])
    {
        if (count($attributes) > 0) {
            foreach ($attributes as $key => $value) {
                if (trim($value) != '') {
                    $this->setAttributes($key, $value);
                }
            }
        }

        return $this;
    }

    /**
     * Set chinese number.
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $limit = (int)$limit ? $limit : 1;
        $limit = ($limit >= self::MAXCOUNT) ? self::MAXCOUNT : $limit;
        $this->limit = $limit;

        return $this;
    }

    /**
     * Generate Chinese ID number.
     * @return array
     * @throws \Exception
     */
    protected function generateChineseID()
    {
        $this->calcCityId();
        $this->calcSex();

        // random number
        $suffix_a = mt_rand(0, 9);
        $suffix_b = mt_rand(0, 9);

        $base = $this->cityid . $this->calcDatatime() . $suffix_a . $suffix_b . $this->sex;
        $idNumber = $base . $this->calcSuffixD($base);

        if ($this->info) {
            $ids = [
                'id'       => $idNumber,
                'province' => $this->getProvince(),
                'city1'    => $this->getCity1(),
                'city2'    => $this->getCity2(),
                'sex'      => $this->getSex(),
                'birth'    => $this->getBirthdate()
            ];
        } else {
            $ids = $idNumber;
        }

        return $ids;
    }

    /**
     * Get timedate
     * param datetime format xxxx-xx-xx
     * @return false|string $datetime
     */
    protected function calcDatatime()
    {
        //random Datatime
        if (is_null($this->datetime)) {
            $startDate = mktime(0, 0, 0, 1, 1, 1950);
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $endDate = mktime(0, 0, 0, $month, $day, $year);
            $birth = mt_rand($startDate, $endDate);
            $datetime = date('Ymd', $birth);
        } else {
            list($year, $month, $day) = explode('-', $this->datetime);
            if (!checkdate($month, $day, $year)) {
                die('Invalided datetime');
            }
            $datetime = $year . $month . $day;
        }
        $this->cityInfo['birthdate'] = $datetime;
        return $datetime;
    }

    /**
     * cale province
     * @return mixed|null
     * @throws \Exception
     */
    protected function calcProvince()
    {
        // Get province
        $this->getProvinces();
        // random province
        if (is_null($this->province)) {
            $province = $this->provinces[random_int(0, self::PROVINCENUM - 1)];
        } // set province by myself
        else {
            if (!in_array($this->province, $this->provinces)) {
                die("The Province is not exists.");
            }
            $province = $this->province;
        }
        $this->cityInfo['province'] = $province;
        return $province;
    }

    /**
     * calc first level city
     * @return int
     * @throws \Exception
     */
    protected function calcCityFirstLevel()
    {
        // Get Rrovince info
        $province = $this->calcProvince();

        // Get citys info from json file
        $this->getCitys();

        // city first level data
        $cityFirstLevel = $this->citys[$province];

        $cLen = count($cityFirstLevel);

        // Get first city number for cityid
        if (is_null($this->city1)) {
            $city1Id = $cLen == 1 ? 0 : random_int(1, $cLen - 1);
            $this->cityInfo['city1'] = array_keys($cityFirstLevel[$city1Id])[0];
        } else {
            // del first element
            array_shift($cityFirstLevel);
            // this pronince first level city list
            $provinceCitys = array_map(function ($list) {
                return array_keys($list)[0];
            }, $cityFirstLevel);

            if (!in_array($this->city1, $provinceCitys)) {
                die("The first level city is not exists.");
            }

            // key value flip
            $provinceCitys = array_flip($provinceCitys);
            $city1Id = $provinceCitys[$this->city1] + 1;
            $this->cityInfo['city1'] = $this->city1;
        }

        return $city1Id;
    }

    /**
     * Get city id for chinese id number before 6
     * @return $this
     * @throws \Exception
     */
    protected function calcCityId()
    {
        // Get first city number
        $city1Id = $this->calcCityFirstLevel();
        // Get first level citys
        $cityFirstLevel = $this->citys[$this->getProvince()];

        // Get second level citys
        $secondLevelCitys = $cityFirstLevel[$city1Id];

        // Get cityid from second city info : city2 is null
        if (is_null($this->city2)) {
            $cityids = array_values($secondLevelCitys)[0];
            if (is_array($cityids)) {
                // random a number
                $randomNumber = random_int(0, count($cityids) - 1);
                $this->cityid = $cityids[$randomNumber]['cityid'];
                $this->cityInfo['city2'] = $cityids[$randomNumber]['cityname'];
            } else {
                $this->cityid = $cityids;
                $this->cityInfo['city2'] = array_values($secondLevelCitys)[1];
            }
        } else {
            // Get second citys
            $baseSecondCitys = array_values($secondLevelCitys)[0];
            $secondCitys = array_map(function ($list) {
                return $list['cityname'];
            }, $baseSecondCitys);
            if (!in_array($this->city2, $secondCitys)) {
                die("The second level city is not exists.");
            }
            // key value flip
            $secondCitys = array_flip($secondCitys);
            $this->cityid = $baseSecondCitys[$secondCitys[$this->city2]]['cityid'];
            $this->cityInfo['city2'] = $this->city2;
        }
        return $this;
    }

    /**
     * Calc sex
     * @return $this
     * @throws \Exception
     */
    protected function calcSex()
    {
        // sex is null , random 1 - 8
        if (is_null($this->sex)) {
            $this->sex = random_int(1, 8);
        } // sex is male
        elseif ($this->sex == self::MALE) {
            $this->sex = 2 * random_int(1, 4) - 1;
        } // sex is female
        else {
            $this->sex = 2 * random_int(1, 4);
        }

        return $this;
    }

    /**
     * Get the provinces from json file
     * @return array|mixed|object
     */
    protected function getProvinces()
    {
        //Get the provinces from json file
        if (sizeof($this->provinces) == 0) {
            $this->provinces = json_decode(file_get_contents(__DIR__ . '/data/provinces.json'), true);
        }
        return $this;
    }

    /**
     * Get citys from Json file
     * @return array|mixed|object
     */
    protected function getCitys()
    {
        //Get the citys from the JSON file
        if (sizeof($this->citys) == 0) {
            $this->citys = json_decode(file_get_contents(__DIR__ . '/data/citys.json'), true);
        }

        //Return the citys
        return $this;
    }

    /**
     * calc chinese id number last word
     * @param $base
     * @return string
     */
    protected function calcSuffixD($base)
    {
        if (strlen($base) <> 17) {
            die('Invalid Length');
        }
        // 权重
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        $sums = 0;
        for ($i = 0; $i < 17; $i++) {
            $sums += substr($base, $i, 1) * $factor[$i];
        }

        $mods = $sums % 11;//10X98765432

        switch ($mods) {
            case 0:
                return '1';
                break;
            case 1:
                return '0';
                break;
            case 2:
                return 'x';
                break;
            case 3:
                return '9';
                break;
            case 4:
                return '8';
                break;
            case 5:
                return '7';
                break;
            case 6:
                return '6';
                break;
            case 7:
                return '5';
                break;
            case 8:
                return '4';
                break;
            case 9:
                return '3';
                break;
            case 10:
                return '2';
                break;
        }
    }


    /**
     * @param $key
     * @param $value
     * @return $this
     */
    protected function setAttributes($key, $value)
    {
        if ($this->isFillable($key)) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    protected function isFillable($key)
    {
        if (in_array($key, $this->getFillable())) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getFillable()
    {
        return $this->fillable;
    }


    /**
     * @return null
     */
    protected function getProvince()
    {
        return $this->cityInfo['province'];
    }

    /**
     * @return mixed
     */
    protected function getCity1()
    {
        return $this->cityInfo['city1'];
    }

    /**
     * @return mixed
     */
    protected function getCity2()
    {
        return $this->cityInfo['city2'];
    }

    /**
     * @return string
     */
    protected function getSex()
    {
        if ($this->sex % 2 != 0) {
            return '男';
        }
        return '女';
    }

    /**
     * @return mixed
     */
    protected function getBirthdate()
    {
        return $this->cityInfo['birthdate'];
    }
}