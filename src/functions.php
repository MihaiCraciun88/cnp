<?php

/**
 *  S AA LL ZZ JJ NNN C
 */
function isCnpValid(string $value) : bool {
    if (strlen($value) !== 13 || preg_match('/[^0-9]/', $value)) {
        return false;
    }

    $date = getCnpDate($value);
    if (!checkdate($date['month'], $date['day'], $date['year'])) {
        return false;
    }

    if (!isSexValid($value, $date)) {
        return false;
    }

    if (getCountyName($value[7] . $value[8]) === null) {
        return false;
    }

    return getCnpCheckSum($value) === intval($value[12]);
}

function getCnpDate(string $value) : array {
    $dt = DateTime::createFromFormat('y', $value[1] . $value[2]);
    return [
        'day'   => (int) ($value[5] . $value[6]),
        'month' => (int) ($value[3] . $value[4]),
        'year'  => (int) $dt->format('Y'),
    ];
}

function isBetween(int $value, int $min, int $max) : bool {
    return $value >= $min && $value <= $max;
}

function isSexValid(string $value, array $date) : bool {
    switch ((int) $value[0]) {
        case 1:
        case 2:
            if (!isBetween($date['year'], 1900, 1999)) {
                return false;
            }
            break;
        case 5:
        case 6:
            if (!isBetween($date['year'], 2000, 2099)) {
                return false;
            }
            break;
        case 0: return false;
    }
    return true;
}

function getCountyName(string $code) : ?string {
    $names = [
        '01' => 'Alba',
        '02' => 'Arad',
        '03' => 'Argeș',
        '04' => 'Bacău',
        '05' => 'Bihor',
        '06' => 'Bistrița-Năsăud',
        '07' => 'Botoșani',
        '08' => 'Brașov',
        '09' => 'Brăila',
        '10' => 'Buzău',
        '11' => 'Caraș-Severin',
        '12' => 'Cluj',
        '13' => 'Constanța',
        '14' => 'Covasna',
        '15' => 'Dâmbovița',
        '16' => 'Dolj',
        '17' => 'Galați',
        '18' => 'Gorj',
        '19' => 'Harghita',
        '20' => 'Hunedoara',
        '21' => 'Ialomița',
        '22' => 'Iași',
        '23' => 'Ilfov',
        '24' => 'Maramureș',
        '25' => 'Mehedinți',
        '26' => 'Mureș',
        '27' => 'Neamț',
        '28' => 'Olt',
        '29' => 'Prahova',
        '30' => 'Satu Mare',
        '31' => 'Sălaj',
        '32' => 'Sibiu',
        '33' => 'Suceava',
        '34' => 'Teleorman',
        '35' => 'Timiș',
        '36' => 'Tulcea',
        '37' => 'Vaslui',
        '38' => 'Vâlcea',
        '39' => 'Vrancea',
        '40' => 'București',
        '41' => 'București - Sector 1',
        '42' => 'București - Sector 2',
        '43' => 'București - Sector 3',
        '44' => 'București - Sector 4',
        '45' => 'București - Sector 5',
        '46' => 'București - Sector 6',
        '51' => 'Călărași',
        '52' => 'Giurgiu',
    ];
    return $names[$code] ?? null;
}

function getCnpCheckSum(string $value) : int {
    $ctrlString = '279146358279';
    $sum = 0;
    for ($i = 0; $i <= 11; $i++) {
        $sum += intval($ctrlString[$i]) * intval($value[$i]);
    }
    $mod = $sum % 11;
    return ($mod === 10) ? 1 : $mod;
}