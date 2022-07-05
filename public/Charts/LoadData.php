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
    $sql = "
        (
            SELECT '0 - 50000km' as label, COUNT(*) as value
            FROM product
            WHERE mileage < 50000
        )
        UNION
        (
            SELECT '50000 - 100000km' as label, COUNT(*) as value
            FROM product
            WHERE mileage >= 50000 AND mileage < 100000
        )
        UNION
        (
            SELECT '100000 - 150000km' as label, COUNT(*) as value
            FROM product
            WHERE mileage >= 100000 AND mileage < 150000
        )
        UNION
        (
            SELECT '150000-200000km' as label, COUNT(*) as value
            FROM product
            WHERE mileage >= 150000 AND mileage < 200000
        )
        UNION
        (
            SELECT '200000-250000km' as label, COUNT(*) as value
            FROM product
            WHERE mileage >= 200000 AND mileage < 250000
        )
        UNION
        (
            SELECT '250000-300000km' as label, COUNT(*) as value
            FROM product
            WHERE mileage >= 250000 AND mileage < 300000
        )
        UNION
        (
            SELECT '> 300000km' as label, COUNT(*) as value
            FROM product
            WHERE mileage >= 300000
        )
    ";

    return $dbService->executeQuery($sql);
}

function getAgeChartInfo(DatabaseService $dbService) {
    $sql = "
        (
            SELECT '0 - 1960g.' as label, COUNT(*) as value
            FROM product
            WHERE age <= 1960
        )
        UNION
        (
            SELECT '1961 - 1970g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 1960 AND age <= 1970
        )
        UNION
        (
            SELECT '1971 - 1980g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 1970 AND age <= 1980
        )
        UNION
        (
            SELECT '1981 - 1990g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 1981 AND age <= 1990
        )
        UNION
        (
            SELECT '1991 - 2000g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 1991 AND age <= 2000
        )
        UNION
        (
            SELECT '2001 - 2005g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 2000 AND age <= 2005
        )
        UNION
        (
            SELECT '2006 - 2010g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 2005 AND age <= 2010
        )
        UNION
        (
            SELECT '2011 - 2015g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 2010 AND age <= 2015
        )
        UNION
        (
            SELECT '2016 - 2020g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 2015 AND age <= 2020
        )
        UNION
        (
            SELECT '2021 - 2022g.' as label, COUNT(*) as value
            FROM product
            WHERE age > 2020 AND age <= 2022
        )
    ";

    return $dbService->executeQuery($sql);
}

function getTransmissionTypeChartInfo(DatabaseService $dbService) {
    $sql = "
        (
            SELECT CONCAT('manuelni(', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.transmissionType LIKE '%Manuelni%'
            GROUP BY t.cnt
        )
        UNION
        (
            SELECT CONCAT('automatski(', COUNT(1) / t.cnt * 100, '%)') AS label, COUNT(1)  AS 'value'
            FROM product
            CROSS JOIN (SELECT COUNT(1) AS cnt FROM product) t
            WHERE product.transmissionType LIKE '%Automatski%'
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
