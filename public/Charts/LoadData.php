<?php

function get10MostPopularLocations(DatabaseService $dbService) {
    $sql = "
        SELECT location as label, COUNT(*) as value
        FROM product
        GROUP BY location
        ORDER BY value DESC
        LIMIT 10;
    ";

    return $dbService->executeQuery($sql);
}

function getMileageChartInfo(DatabaseService $dbService) {
    $data = getNumberOfCarsPerMileageOffsets($dbService, 'mileage', 'km', 0, 50000);
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'mileage', 'km', 50000, 100000));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'mileage', 'km', 100000, 150000));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'mileage', 'km', 150000, 200000));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'mileage', 'km', 200000, 250000));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'mileage', 'km', 250000, 300000));
    return array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'mileage', 'km', 300000));
}

function getAgeChartInfo(DatabaseService $dbService) {
    $data = getNumberOfCarsPerMileageOffsets($dbService, 'age', 'god.', 0, 1960);
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'age', 'god.', 1960, 1970));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'age', 'god.', 1970, 1980));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'age', 'god.', 1980, 1990));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'age', 'god.', 1990, 2000));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'age', 'god.', 2000, 2010));
    $data = array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'age', 'god.', 2010, 2020));
    return array_merge($data, getNumberOfCarsPerMileageOffsets($dbService, 'age', 'god.', 2020, 2022));
}

function getTransmissionTypeChartInfo(DatabaseService $dbService) {
    $sql = "
        (
            SELECT CONCAT('manuelni(', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.transmissionType LIKE '%manuelni%'
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('automatski(', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.transmissionType LIKE '%automatski%'
            GROUP BY t.cnt
        );
    ";

    return $dbService->executeQuery($sql);
}

function getPriceChartInfo(DatabaseService $dbService) {
    $sql = "
        (
            SELECT CONCAT('0 - 2000€ (', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.price < 2000
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('2000€ - 4999€ (', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.price >= 2000 AND product.price < 5000
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('5000€ - 9999€ (', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.price >= 5000 AND product.price < 10000
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('10000€ - 14999€ (', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.price >= 10000 AND product.price < 15000
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('15000€ - 19999€ (', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.price >= 15000 AND product.price < 20000
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('20000€ - 24999€ (', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.price >= 20000 AND product.price < 25000
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('25000€ - 29999€ (', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.price >= 25000 AND product.price < 30000
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('30000€ - / (', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.price >= 30000
            GROUP BY t.cnt
        );
    ";

    return $dbService->executeQuery($sql);
}

function getNumberOfCarsPerMileageOffsets(DatabaseService $dbService, $columnName, $metricName, $lowerOffset, $higherOffset = null) {
    if ($higherOffset === null) {
        $labelName = "'> {$lowerOffset}{$metricName}'";
        $where_condition = "{$columnName} >= {$lowerOffset}";
    } else {
        $labelName = "'{$lowerOffset}{$metricName} - {$higherOffset}{$metricName}'";
        $where_condition = "{$columnName} >= {$lowerOffset} AND {$columnName} < {$higherOffset}";
    }

    $sql = "
        SELECT {$labelName} as label, COUNT(*) as value
        FROM product
        WHERE {$where_condition}
    ";

    return $dbService->executeQuery($sql);
}
