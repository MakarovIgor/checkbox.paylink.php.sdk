<?php


namespace igormakarov\PayLink\Mappers;


use igormakarov\PayLink\Models\PurchaseResult;

class PurchaseResultMapper
{
    public static function newInstance(array $data): PurchaseResult
    {
        return new PurchaseResult(
            $data['terminal'],
            $data['rrn'],
            $data['card_mask'],
            $data['card_name'],
            $data['auth_code'],
            $data['payment_system'],
            $data['receipt_no'],
            $data['acquirer_and_seller'],
            isset($data['commission']) ?? 0
        );
    }
}