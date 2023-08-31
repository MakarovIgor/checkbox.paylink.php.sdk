<?php

namespace igormakarov\PayLink\Models;

class PurchaseResult
{
    private string $terminal;
    private string $rrn;
    private string $cardMask;
    private string $cardName;
    private string $authCode;
    private string $paymentSystem;
    private string $receiptNo;
    private string $acquirerAndSeller;
    private int $code;
    private int $commission;

    public function __construct(
        string $terminal,
        string $rrn,
        string $cardMask,
        string $cardName,
        string $authCode,
        string $paymentSystem,
        string $receiptNo,
        string $acquirerAndSeller,
        int $code,
        int $commission
    ) {
        $this->terminal = $terminal;
        $this->rrn = $rrn;
        $this->cardMask = $cardMask;
        $this->cardName = $cardName;
        $this->authCode = $authCode;
        $this->paymentSystem = $paymentSystem;
        $this->receiptNo = $receiptNo;
        $this->acquirerAndSeller = $acquirerAndSeller;
        $this->code = $code;
        $this->commission = $commission;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function acquirerAndSeller(): string
    {
        return $this->acquirerAndSeller;
    }

    public function authCode(): string
    {
        return $this->authCode;
    }

    public function cardMask(): string
    {
        return $this->cardMask;
    }

    public function cardName(): string
    {
        return $this->cardName;
    }

    public function commission(): string
    {
        return $this->commission;
    }

    public function paymentSystem(): string
    {
        return $this->paymentSystem;
    }

    public function receiptNo(): string
    {
        return $this->receiptNo;
    }

    public function rrn(): string
    {
        return $this->rrn;
    }

    public function terminal(): string
    {
        return $this->terminal;
    }
}