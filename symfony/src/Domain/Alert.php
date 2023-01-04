<?php

namespace App\Domain;

use phpDocumentor\Reflection\Types\Boolean;

class Alert
{
    private bool $isAlert ;
    private string $type ;
    private string $date ;

    /**
     * @param bool $isAlert
     * @param string $date
     */
    public function __construct(bool $isAlert, string $date)
    {
        $this->isAlert = $isAlert;
        $this->date = $date;
    }

    public function getIsAlert(): ?bool
    {
        return $this->isAlert;
    }

    public function setIsAlert(bool $isAlert): self
    {
        $this->isAlert = $isAlert;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
}