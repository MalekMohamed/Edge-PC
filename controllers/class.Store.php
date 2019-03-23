<?php

/**
 * Created by PhpStorm.
 * User: Legacy
 * Date: 7/14/2018
 * Time: 1:13 PM
 */
class Store extends Config
{
    public static $category_array = array('Ram', 'Case', 'GPU', 'CPU', 'MotherBoard', 'Storage', 'Cooling - Fans', 'Monitor', 'PowerSupply', 'Laptops', 'Bundle', 'Accessory', 'Others');
    public static $Brands = array('Atech', 'Acer', 'Adata', 'AFOX', 'AMD', 'Antec', 'Aopen', 'Apacer', 'APC', 'Apple', 'Arctic', 'ASRock', 'ASUS', 'Auvio', 'Belkin', 'BenQ', 'Biostar', 'Bitfenix', 'Brother', 'Canon', 'Cherry', 'CISCO', 'Cooler', 'Master', 'Corsair', 'Creative', 'Crucial', 'CRYORIG', 'D-link', 'Deepcool', 'Dell', 'Dolphin', 'ECS', 'ELITEGROUP', 'Edimax', 'Enermax', 'EVGA', 'FSP', 'Fujitsu', 'GSkill', 'Gainward', 'Galax', 'Galaxy', 'GAMDIAS', 'Gamma', 'Genius', 'Gigabyte', 'HEC', 'HGST', 'HIS', 'HP', 'HTC', 'Huawei', 'iLuv', 'Infosec', 'InnoD', 'intel', 'Kaspersky', 'Lab', 'Kingston', 'Lacie', 'Lenovo', 'Lexar', 'LG', 'Linksys', 'Liteon', 'Logitech', 'Manhattan', 'Manli', 'Maxtor', 'McAfee', 'Microsoft', 'Miracle-DL', 'MSI', 'Netgear', 'Netis', 'noctua', 'NZXT', 'OKI', 'Palit', 'Philips', 'Pioneer', 'Plextor', 'PNY', 'powercolor', 'Raidmax', 'rapoo', 'Razer', 'REDRAGON', 'Ricoh', 'ROCCAT', 'Samsung', 'Sandisk', 'Sapphire', 'Seagate', 'Seasonic', 'Silicon', 'Power', 'SilverStone', 'Sollatek', 'Sony', 'SPEEDLINK', 'steelseries', 'SystemMax', 'Team Group', 'Tenda', 'Tevii', 'Thermaltake', 'Thomson', 'TIGER', 'Tornado', 'Toshiba', 'TOTOLINK', 'TP-Link', 'Transcend', 'Viewsonic', 'VisionPlus', 'Wacom', 'Western', 'Digital', 'XFX', 'Zalman', 'Zotac');
public static $category_data = array(
        'MotherBoard' => array(
            'Chipset' => array('Intel','AMD'),
            'Brands' => array('Gigabyte' , 'Asus' ,'MSI' , 'ASRock','EVGA')
        ),
        'Ram' => array(
            'Brands' => array('G.Skill','Kingston' , 'AData','Gigabyte','Crucial','Corsair')
        ),
        'PowerSupply' => array(
            'Brands' => array('Bitfenix' , 'Cooler Master','Corsair','EVGA','FSP','Gigabyte','Gamma','HEC','Seasonic','Thermaltake','XFX','NZXT','Cougar')
        ),
        'CPU' => array(
            'Brands' => array('Intel','AMD')
        ),
        'GPU' => array(
            'Chipset' => array('Nvidia','AMD'),
            'Brands' => array('Asus','EVGA','AFOX','Galax','Gigabyte','MSI','Zotac','Sapphire','PNY','XFX','Palit','Manli','HIS')
        ),
        'Case' => array(
            'Brands' => array('Bitfenix','Cooler Master','Gamma','Gigabyte','HEC','NZXT','Thermaltake','Corsair')
        ),
        'Cooling - Fans' => array(
            'Brands' => array('Bitfenix','Cooler Master','FSP','Gigabyte','GAMDIAS','NZXT','Thermaltake','Corsair')
        ),
        'Monitor' => array(
            'Panel' => array('IPS','LED','PLS','VA','TN'),
            'Brands' => array('Asus','BenQ','Dell','HP','MSI','LG','Samsung','Corsair')
        ),
        'Storage' => array(
            'Size' => array('SSD','External','HDD','2.5"','3.5"'),
            'Brands' => array('AData','Crucial','Gigabyte','intel','KingSton','LG','Samsung','Corsair','Seagate','Team Group','Western Digital','Transcend','Toshiba','Silicon Power','Liteon')
        ),
        'Laptop' => array(
            'Brands' => array('Apple','Dell','HP','Hyundai Technology','Kingston','Lenovo','Toshiba','Western Digital')
        ),
        'Accessory' => array(
            'Device' => array('Headsets','Keyboard','Mouse','Keyboard & Mouse Combos'),
            'Brands' => array('A4tech','ASUS','Cooler Master','Corsair','G.Skill','GAMDIAS','Genius','Gigabyte','HEC','HP','Kingston','Logitech','MSI','Razer','ROCCAT','Steelseries','Thermaltake')
        ),
    );
    public static function status($state)
    {
        switch ($state) {
            case 0:
                return '<span class="text-inverse">Pending</span>';
                break;
            case 1:
                return '<span class="text-success">Available</span>';
                break;
            case 2:
                return '<span class="text-custom">Sold</span>';
                break;
            case 3:
                return '<span class="text-muted">Removed</span>';
                break;
            case 4:
                return '<span class="text-danger">Declined</span>';
                break;
        }
    }
public static function reportsStates($state)
    {
        switch ($state) {
            case 0:
                return '<span class="text-danger">Pending</span>';
                break;
            case 1:
                return '<span class="text-success">Viewed</span>';
                break;
            case 2:
                return '<span class="text-info">Declined</span>';
                break;
        }
    }
    public function getItems($page)
    {
        $per_page = $this->per_page;
        $row_start = $per_page * ($page - 1);

        $query = $this->conn->prepare("SELECT * FROM store WHERE Status != 0 AND Status != 3  AND Status != 4 ORDER BY Date ASC LIMIT $row_start,$per_page");
        $query->execute();
        return $query->fetchAll();
    }

    public function getPendingItems()
    {
        $query = $this->conn->prepare('SELECT * FROM store WHERE Status != 1 ORDER BY Date');
        $query->execute();
        return $query->fetchAll();
    }

    public function get_all_items()
    {
        $query = $this->conn->prepare('SELECT * FROM store WHERE Status != 3 AND Status != 0 AND Status != 4 ORDER BY Date');
        $query->execute();
        return $query->fetchAll();
    }

    public function get_items($data)
    {
        if (is_array($data)) {
            $sort = $data['sort'];
            $cate = $data['cate'];
            $id = $data['id'];
            $name = $data['name'];
            $user = $data['user'];
            $brand = $data['brand'];
            $status = $data['Status'];
            $page = $data['page'];
            $per_page = $this->per_page;
            $row_start = $per_page * ($page - 1);
            $sort_array = array('Date', 'PriceHigh', 'Condition', 'PriceLow');
            if (!in_array($sort, $sort_array)) {
                $sort = 'Date ASC ';
            } else {
                if ($sort == 'PriceHigh') {
                    $sort = 'Price DESC ';
                } elseif ($sort == 'PriceLow') {
                    $sort = 'Price ASC ';
                } elseif ($sort == 'Cond') {
                    $sort = 'Cond ASC ';
                } else {
                    $sort = 'Date ASC ';
                }
            }
            if (!empty($page)) {
                $limit = 'LIMIT ' . $row_start . ',' . $per_page;
            } else {
                $limit = '';
            }
            if (!empty($status)) {
                $stat = 'AND Status != 0 AND Status != 3 AND Status != 4';
            } else {
                $stat = '';
            }
            if ($data['brand'] == 'All') {
                $brand = '';
            }
            if (!empty($brand) && !empty($cate)) {
                $query = $this->conn->prepare('SELECT * FROM store WHERE Category = ? AND Brand = ? '.$stat.' ORDER BY  ' . $sort . $limit);
                $query->execute(array($cate, $brand));
            } else {
                $query = $this->conn->prepare('SELECT * FROM store WHERE Category = ? OR ID = ? OR Name = ? OR Brand = ? OR User = ? '.$stat.' ORDER BY  ' . $sort . $limit);
                $query->execute(array($cate, $id, $name, $brand, $user));
            }
            return $query->fetchAll();

        } else {
            return $this->getItems($data);
        }
    }

    public function Updateitem($id, $status = 1)
    {
        $query = $this->conn->prepare("UPDATE store SET Status = ? WHERE ID = ?");
        if ($query->execute(array($status, $id))) {
            return true;
        } else {
            return false;
        }
    }

    public function Additem($data)
    {
        if (is_array($data)) {
            $query = $this->conn->prepare("INSERT INTO store (Name,Brand,Category,extData,Price,Cond,Description,Date,User,images) VALUES (:Name,:Brand,:Category,:extData,:Price,:Cond,:Description,:Date,:User,:images)");
            if ($query->execute($data)) {
                return true;
            } else {
                return false;
            }
        }
    }
}

function numhash($n)
{
    return (((0x0000FFFF & $n) << 16) + ((0xFFFF0000 & $n) >> 16));
}

function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function reArrayFiles($file)
{
    $file_ary = array();
    $file_count = count($file['name']);
    $file_key = array_keys($file);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_key as $val) {
            $file_ary[$i][$val] = $file[$val][$i];
        }
    }
    return $file_ary;
}

function deleteAll($str)
{
    $files = glob($str . '/*');

//Loop through the file list.
    foreach ($files as $file) {
        //Make sure that this is a file and not a directory.
        if (is_file($file)) {
            //Use the unlink function to delete the file.
            unlink($file);
        }
    }
}