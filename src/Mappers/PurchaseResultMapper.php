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
            isset($data['code']) ?? 0,
            isset($data['commission']) ?? 0
        );
    }

    public static function toArray(PurchaseResult $purchaseResult): array
    {
        return [
            'terminal' => $purchaseResult->terminal(),
            'rrn' => $purchaseResult->rrn(),
            'card_mask' => $purchaseResult->cardMask(),
            'card_name' => $purchaseResult->cardName(),
            'auth_code' => $purchaseResult->authCode(),
            'payment_system' => $purchaseResult->paymentSystem(),
            'receipt_no' => $purchaseResult->receiptNo(),
            'acquirer_and_seller' => $purchaseResult->acquirerAndSeller(),
            'code' => $purchaseResult->code(),
            'commission' => $purchaseResult->commission()
        ];
    }
}
