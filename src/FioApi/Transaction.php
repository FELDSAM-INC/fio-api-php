<?php
declare(strict_types = 1);

namespace FioApi;

class Transaction
{
    const REMITTANCE_INFO_LENGTH = 35;

    /** @var string */
    protected $id;

    /** @var \DateTimeImmutable */
    protected $date;

    /** @var float */
    protected $amount;

    /** @var string */
    protected $currency;

    /** @var string|null */
    protected $accountNumber;

    /** @var string|null */
    protected $bankCode;

    /** @var string|null */
    protected $bankName;

    /** @var string|null */
    protected $senderName;

    /** @var string|null */
    protected $constantSymbol;

    /** @var string|null */
    protected $variableSymbol;

    /** @var string|null */
    protected $specificSymbol;

    /** @var string|null */
    protected $userIdentity;

    /** @var string|null */
    protected $userMessage;

    /** @var string */
    protected $transactionType;

    /** @var string|null */
    protected $performedBy;

    /** @var string|null */
    protected $comment;

    /** @var float|null */
    protected $paymentOrderId;

    /** @var string|null */
    protected $specification;

    protected function __construct(
        string $id,
        \DateTimeImmutable $date,
        float $amount,
        string $currency,
        ?string $accountNumber,
        ?string $bankCode,
        ?string $bankName,
        ?string $senderName,
        ?string $constantSymbol,
        ?string $variableSymbol,
        ?string $specificSymbol,
        ?string $userIdentity,
        ?string $userMessage,
        string $transactionType,
        ?string $performedBy,
        ?string $comment,
        ?float $paymentOrderId,
        ?string $specification
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
        $this->bankName = $bankName;
        $this->senderName = $senderName;
        $this->constantSymbol = $constantSymbol;
        $this->variableSymbol = $variableSymbol;
        $this->specificSymbol = $specificSymbol;
        $this->userIdentity = $userIdentity;
        $this->userMessage = $userMessage;
        $this->transactionType = $transactionType;
        $this->performedBy = $performedBy;
        $this->comment = $comment;
        $this->paymentOrderId = $paymentOrderId;
        $this->specification = $specification;
    }

    /**
     * @param \stdClass $data Transaction data from JSON API response
     * @return Transaction
     */
    public static function createFromJson(\stdClass $data): Transaction
    {
        $mapColumnToProps = [
            'column22' => 'id',
            'column0'  => 'date',
            'column1'  => 'amount',
            'column14' => 'currency',
            'column2'  => 'accountNumber',
            'column3'  => 'bankCode',
            'column12' => 'bankName',
            'column4'  => 'constantSymbol',
            'column5'  => 'variableSymbol',
            'column6'  => 'specificSymbol',
            'column7'  => 'userIdentity',
            'column16' => 'userMessage',
            'column8'  => 'transactionType',
            'column9'  => 'performedBy',
            'column25' => 'comment',
            'column17' => 'paymentOrderId',
            'column18' => 'specification',
        ];

        $newData = new \stdClass();
        foreach ($data as $key => $value) {
            if (isset($mapColumnToProps[$key]) && $value !== null) {
                $newKey = $mapColumnToProps[$key];
                if ($newKey === 'date') {
                    $newData->{$newKey} = new \DateTime($value->value);
                } else {
                    $newData->{$newKey} = $value->value;
                }
            }
        }

        return self::create($newData);
    }

    public static function create(\stdClass $data)
    {
        return new self(
            !empty($data->id) ? $data->id : null,
            new \DateTimeImmutable($data->column0->value), //Datum
            $data->date,
            $data->amount,
            $data->currency,
            !empty($data->accountNumber) ? $data->accountNumber : null,
            !empty($data->bankCode) ? $data->bankCode : null,
            !empty($data->bankName) ? $data->bankName : null,
            !empty($data->constantSymbol) ? $data->constantSymbol : null,
            !empty($data->variableSymbol) ? $data->variableSymbol : '0',
            !empty($data->specificSymbol) ? $data->specificSymbol : null,
            !empty($data->userIdentity) ? $data->userIdentity : null,
            !empty($data->userMessage) ? $data->userMessage : null,
            !empty($data->transactionType) ? $data->transactionType : null,
            !empty($data->performedBy) ? $data->performedBy : null,
            !empty($data->comment) ? $data->comment : null,
            !empty($data->paymentOrderId) ? $data->paymentOrderId : null,
            !empty($data->specification) ? $data->specification : null
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @deprecated
     *
     * @return string
     */
    public function getSenderAccountNumber(): ?string
    {
        trigger_error(__METHOD__.' is deprecated use getAccountNumber() instead.', E_USER_DEPRECATED);

        return $this->getAccountNumber();
    }

    /**
     * @return string
     */
    public function getBankCode(): ?string
    {
        return $this->bankCode;
    }

    /**
     * @deprecated
     *
     * @return string
     */
    public function getSenderBankCode(): ?string
    {
        trigger_error(__METHOD__.' is deprecated use getBankCode() instead.', E_USER_DEPRECATED);

        return $this->getBankCode();
    }

    /**
     * @return string|null
     */
    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    /**
     * @deprecated
     *
     * @return string
     */
    public function getSenderName(): ?string
    {
        trigger_error(__METHOD__.' is deprecated use getBankName() instead.', E_USER_DEPRECATED);

        return $this->getBankName();
    }

    public function getConstantSymbol(): ?string
    {
        return $this->constantSymbol;
    }

    public function getVariableSymbol(): ?string
    {
        return $this->variableSymbol;
    }

    public function getSpecificSymbol(): ?string
    {
        return $this->specificSymbol;
    }

    /**
     * @return string
     */
    public function getUserIdentity(): ?string
    {
        return $this->userIdentity;
    }

    public function getUserMessage(): ?string
    {
        return $this->userMessage;
    }

    /**
     * Gets first chunk of remittance info.
     *
     * @return string
     */
    public function getRemittanceInfo1()
    {
        return (string) substr($this->getUserMessage(), 0, self::REMITTANCE_INFO_LENGTH);
    }

    /**
     * Gets second chunk of remittance info.
     *
     * @return string
     */
    public function getRemittanceInfo2()
    {
        return (string) substr($this->getUserMessage(), self::REMITTANCE_INFO_LENGTH, self::REMITTANCE_INFO_LENGTH);
    }

    /**
     * Gets third chunk of remittance info.
     *
     * @return string
     */
    public function getRemittanceInfo3()
    {
        return (string) substr($this->getUserMessage(), 2 * self::REMITTANCE_INFO_LENGTH, self::REMITTANCE_INFO_LENGTH);
    }

    /**
     * Gets fourth chunk of remittance info.
     *
     * @return string
     */
    public function getRemittanceInfo4()
    {
        return (string) substr($this->getUserMessage(), 3 * self::REMITTANCE_INFO_LENGTH, self::REMITTANCE_INFO_LENGTH);
    }

    /**
     * @return string
     */
    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function getPerformedBy(): ?string
    {
        return $this->performedBy;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getPaymentOrderId(): ?float
    {
        return $this->paymentOrderId;
    }

    public function getSpecification(): ?string
    {
        return $this->specification;
    }
}
