<?php

class ProductRepository {
    private DatabaseService $databaseService;

    public function __construct(DatabaseService $databaseService) {
        $this->databaseService = $databaseService;
    }

    public function mapDataToNewProduct(array $data): ?Product {
        if (empty($data)) {
            return null;
        }

        $product = new Product();
        $product->setAge($data['age'] ?? null);
        $product->setBrand($data['brand'] ?? null);
        $product->setCarBodyType($data['carBodyType'] ?? null);
        $product->setColor($data['color'] ?? null);
        $product->setCubicCapacity($data['cubicCapacity'] ?? null);
        $product->setDescription($data['description'] ?? null);
        $product->setDoorType($data['doorType'] ?? null);
        $product->setEngineEmissionClass($data['engineEmissionClass'] ?? null);
        $product->setEnginePower($data['enginePower'] ?? null);
        $product->setFuelType($data['fuelType'] ?? null);
        $product->setLink($data['link'] ?? null);
        $product->setLocation($data['location'] ?? null);
        $product->setMileage($data['mileage'] ?? null);
        $product->setModel($data['model'] ?? null);
        $product->setNumberOfSeats($data['numberOfSeats'] ?? null);
        $product->setPrice($data['price'] ?? null);
        $product->setState($data['state'] ?? null);
        $product->setTransmissionType($data['transmissionType'] ?? null);
        $product->setWheelSide($data['wheelSide'] ?? null);

        return $product;
    }

    /**
     * @throws Exception
     */
    public function insertProductToDatabase(Product $product): void {
        $databaseService = $this->databaseService;

        if (!$databaseService->isConnectionEstablished()) {
            $databaseService->connect();
        }

        $columnNames = [];
        $values = [];

        $properties = $product->getAllProperties();
        foreach ($properties as $key => $value) {
            if ($key === 'id') {
                continue; // id is autoincrement column
            }

            $preparedValue = 'NULL';
            if (!empty($value)) {
                $preparedValue = mysqli_real_escape_string($databaseService->getConnection(), $value);
                $preparedValue = "'{$preparedValue}'";
            }

            $columnNames[] = $key;
            $values[] = $preparedValue;
        }

        if (empty($columnNames) || empty($values)) {
            return;
        }

        $columnNamesText = implode(', ', $columnNames);
        $valuesText = implode(", ", $values);

        $sql = "INSERT INTO product ({$columnNamesText}) VALUES ({$valuesText})";

        $databaseService->executeQuery($sql);
    }

    /**
     * @return DatabaseService
     */
    public function getDatabaseService(): DatabaseService {
        return $this->databaseService;
    }

    /**
     * @param DatabaseService $databaseService
     */
    public function setDatabaseService(DatabaseService $databaseService): void {
        $this->databaseService = $databaseService;
    }
}