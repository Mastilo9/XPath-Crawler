<?php

class Product {
    private int $id;
    private ?string $link;
    private ?string $age;
    private ?string $brand;
    private ?string $carBodyType;
    private ?string $color;
    private ?string $cubicCapacity;
    private ?string $description;
    private ?string $doorType;
    private ?string $engineEmissionClass;
    private ?string $enginePower;
    private ?string $fuelType;
    private ?string $location;
    private ?string $mileage;
    private ?string $model;
    private ?string $numberOfSeats;
    private ?string $price;
    private ?string $state;
    private ?string $transmissionType;
    private ?string $wheelSide;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string {
        return $this->link;
    }

    /**
     * @param string|null $link
     */
    public function setLink(?string $link): void {
        $this->link = $link;
    }

    /**
     * @return string|null
     */
    public function getAge(): ?string {
        return $this->age;
    }

    /**
     * @param string|null $age
     */
    public function setAge(?string $age): void {
        $this->age = $age;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     */
    public function setBrand(?string $brand): void {
        $this->brand = $brand;
    }

    /**
     * @return string|null
     */
    public function getCarBodyType(): ?string {
        return $this->carBodyType;
    }

    /**
     * @param string|null $carBodyType
     */
    public function setCarBodyType(?string $carBodyType): void {
        $this->carBodyType = $carBodyType;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string {
        return $this->color;
    }

    /**
     * @param string|null $color
     */
    public function setColor(?string $color): void {
        $this->color = $color;
    }

    /**
     * @return string|null
     */
    public function getCubicCapacity(): ?string {
        return $this->cubicCapacity;
    }

    /**
     * @param string|null $cubicCapacity
     */
    public function setCubicCapacity(?string $cubicCapacity): void {
        $this->cubicCapacity = $cubicCapacity;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getDoorType(): ?string {
        return $this->doorType;
    }

    /**
     * @param string|null $doorType
     */
    public function setDoorType(?string $doorType): void {
        $this->doorType = $doorType;
    }

    /**
     * @return string|null
     */
    public function getEngineEmissionClass(): ?string {
        return $this->engineEmissionClass;
    }

    /**
     * @param string|null $engineEmissionClass
     */
    public function setEngineEmissionClass(?string $engineEmissionClass): void {
        $this->engineEmissionClass = $engineEmissionClass;
    }

    /**
     * @return string|null
     */
    public function getEnginePower(): ?string {
        return $this->enginePower;
    }

    /**
     * @param string|null $enginePower
     */
    public function setEnginePower(?string $enginePower): void {
        $this->enginePower = $enginePower;
    }

    /**
     * @return string|null
     */
    public function getFuelType(): ?string {
        return $this->fuelType;
    }

    /**
     * @param string|null $fuelType
     */
    public function setFuelType(?string $fuelType): void {
        $this->fuelType = $fuelType;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string {
        return $this->location;
    }

    /**
     * @param string|null $location
     */
    public function setLocation(?string $location): void {
        $this->location = $location;
    }

    /**
     * @return string|null
     */
    public function getMileage(): ?string {
        return $this->mileage;
    }

    /**
     * @param string|null $mileage
     */
    public function setMileage(?string $mileage): void {
        $this->mileage = $mileage;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string {
        return $this->model;
    }

    /**
     * @param string|null $model
     */
    public function setModel(?string $model): void {
        $this->model = $model;
    }

    /**
     * @return string|null
     */
    public function getNumberOfSeats(): ?string {
        return $this->numberOfSeats;
    }

    /**
     * @param string|null $numberOfSeats
     */
    public function setNumberOfSeats(?string $numberOfSeats): void {
        $this->numberOfSeats = $numberOfSeats;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string {
        return $this->price;
    }

    /**
     * @param string|null $price
     */
    public function setPrice(?string $price): void {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void {
        $this->state = $state;
    }

    /**
     * @return string|null
     */
    public function getTransmissionType(): ?string {
        return $this->transmissionType;
    }

    /**
     * @param string|null $transmissionType
     */
    public function setTransmissionType(?string $transmissionType): void {
        $this->transmissionType = $transmissionType;
    }

    /**
     * @return string|null
     */
    public function getWheelSide(): ?string {
        return $this->wheelSide;
    }

    /**
     * @param string|null $wheelSide
     */
    public function setWheelSide(?string $wheelSide): void {
        $this->wheelSide = $wheelSide;
    }

    public function getAllProperties(): array {
        return get_object_vars($this);
    }
}