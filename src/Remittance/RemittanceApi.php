<?php

namespace Seasofthpyosithu\GmoPayment\Remittance;

use Seasofthpyosithu\GmoPayment\GmoPaymentApi\Client;
use Seasofthpyosithu\GmoPayment\GmoPaymentApi\GmoPaymentException;

class RemittanceApi extends Client
{
    /**
     * @var string
     */
    private $shop_id;

    /**
     * @var string
     */
    private $shop_pass;


    protected $api = [
        // Account api
        'accountRegistration' => 'AccountRegistration.idPass',
        'accountSearch' => 'AccountSearch.idPass',
        'deleteAccount' => 'AccountRegistration.idPass',

        // Deposit Api
        'depositRegistration' => 'DepositRegistration.idPass',
        'depositSearch' => 'DepositSearch.idPass',

        // Mail Deposit Api

        'mailDepositRegistration' => 'MailDepositRegistration.idPass',
        'mailDepositSearch' => 'MailDepositSearch.idPass',

        // Search Balance Api
        'balanceSearch' => 'BalanceSearch.idPass'

    ];

    public function __construct()
    {
        $this->shop_id = config('gmo.remittance_shop_id');
        $this->shop_pass = config('gmo.remittance_shop_pass');
        $this->url = config('gmo.remittance_host');
        $this->url .=  '/api/';
        parent::__construct();
    }

    /**
     * @param string $bank_id generate unique id to register into gmo
     * @param string $bank_code
     * @param string $branch_code
     * @param integer $account_type
     *      1: NORMAL
     *      2: CURRENT
     *      4 : SAVING
     * @param $account_name
     * @param $account_number
     * @param $account_method
     *      1: CREATE
     *      2: UPDATE
     * @param array $options {
     *      Branch_Code_Jp: string,
     *      Account_Number_Jp: string,
     *      Free: string Metadata
     * }
     *
     * @return array {
     *      Bank_ID: string,
     *      Method: string
     * }
     *
     * @throws RemittanceException
     * @throws GmoPaymentException
     */
    public function accountRegistration(string $bank_id, string $bank_code, string $branch_code, int $account_type, string $account_name, string $account_number, int $account_method, array $options = [])
    {
        if ($account_type !== AccountType::NORMAL && $account_type !== AccountType::CURRENT && $account_type !== AccountType::SAVING) {
            throw new RemittanceException('Invalid Account Type');
        }
        if ($account_method !== AccountMethod::CREATE && $account_method !== AccountMethod::UPDATE) {
            throw new RemittanceException('Invalid Account Method');
        }

        $params = array_merge($options, [
            'Bank_ID' => $bank_id,
            'Bank_Code' => $bank_code,
            'Branch_Code' => $branch_code,
            'Account_Type' => $account_type,
            'Account_Name' => $account_name,
            'Account_Number' => $account_number,
            'Method' => $account_method
        ]);
        return $this->invoke(__FUNCTION__, $params);

    }

    /**
     * @param string $bank_id
     *
     * @return array{Bank_ID: string, Method: string}
     * @throws GmoPaymentException
     * @throws RemittanceException
     */
    public function deleteAccount(string $bank_id)
    {
        return $this->invoke(__FUNCTION__, ['Bank_ID' => $bank_id, 'Method' => AccountMethod::DELETE]);
    }

    /**
     * @param string $bank_id
     *
     * @return array{
     *      Bank_ID: string,
     *      Delete_Flag: string,
     *      Bank_Name: string,
     *      Bank_Code: string,
     *      Branch_Name: string,
     *      Branch_Code: string,
     *      Account_Type: string  1: NORMAL | 2: CURRENT | SAVING,
     *      Account_Number: string,
     *      Account_Name: string,
     *      Free: string,
     *      Branch_Code_Jpbank: string,
     *      Account_Number_Jpbank: string
     *  }
     * @throws GmoPaymentException
     * @throws RemittanceException
     */
    public function accountSearch(string $bank_id)
    {
        return $this->invoke(__FUNCTION__, ['Bank_ID' => $bank_id]);
    }


    /**
     * transfer or deposit into gmo registered bank account
     * @param string $deposit_id
     * @param int $deposit_method
     *      1: CREATE
     *      2: CANCEL
     * @param string|null $bank_id
     * @param integer|null $amount
     *
     * @return array{
     *      Deposit_ID: string,
     *      Bank_ID: string,
     *      Method: string,
     *      Amount: string?,
     *      Bank_Fee: string?,
     * }
     * @throws RemittanceException
     * @throws GmoPaymentException
     */
    public function depositRegistration(string $deposit_id, int $deposit_method ,string $bank_id = null, int $amount = null)
    {

        if ($deposit_method !== DepositMethod::CREATE && $deposit_method !== DepositMethod::CANCEL) {
            throw new RemittanceException("Invalid deposit method");
        }

        if ($deposit_method === DepositMethod::CREATE && (!$bank_id || !$amount)) {
            throw new RemittanceException("BankId or Amount can't be null when creating new deposit");
        }

        $params = [
            'Deposit_ID' => $deposit_id,
            'Method' => $deposit_method,
        ];

        if ($deposit_method === DepositMethod::CREATE) {
            $params['Bank_ID'] = $bank_id;
            $params['Amount'] = $amount;
        }

        return $this->invoke(__FUNCTION__, $params);
    }


    /**
     * search transferred or deposited into gmo registered bank account with deposit id
     * @param string $deposit_id
     *
     * @return array {
     *      Deposit_ID: string,
     *      Bank_ID: string,
     *      Bank_Name: string,
     *      Bank_Code: string,
     *      Branch_Name: string,
     *      Branch_Code: string,
     *      Account_Type: string, 1: NORMAL | 2: CURRENT | 4: SAVING
     *      Account_Number: string,
     *      Account_Name: string,
     *      Free: string,
     *      Amount: string,
     *      BankFee: string,
     *      Result: string,
     *      Branch_Code_Jpbank: string?
     *      Account_Number_Jpbank: string?
     *      Deposit_Date: string?
     *      Result_Detail: string?
     * }
     * @throws GmoPaymentException
     * @throws RemittanceException
     */
    public function depositSearch(string $deposit_id)
    {
        return $this->invoke(__FUNCTION__, ['Deposit_ID' => $deposit_id]);
    }

    /**
     * @param string $deposit_id
     * @param int $deposit_method
     *      1: CREATE
     *      2: CANCEL
     * @param string|null $mail_address
     * @param string|null $shop_mail_address
     * @param string|null $account_name
     * @param int $expire expire date (e.g. 5)
     * @param null $amount
     *
     * @return array {
     *      Deposit_ID: string,
     *      Method: string, 1: CREATE | 2: CANCEL
     *      Amount: string,
     *      Expire: string,
     * }
     *
     * @throws GmoPaymentException
     * @throws RemittanceException
     */
    public function mailDepositRegistration(string $deposit_id, int $deposit_method, string $mail_address = null, string $shop_mail_address = null ,string $account_name = null, int $expire = null, $amount = null){

        if ($deposit_method !== DepositMethod::CREATE && $deposit_method !== DepositMethod::CANCEL) {
            throw new RemittanceException("Invalid deposit method");
        }

        if ($deposit_method === DepositMethod::CREATE && (!$mail_address || !$shop_mail_address || !$account_name || !$expire || !$amount)) {
            throw new RemittanceException("MailAddress, Shop Mail Address, Account Name, Expire, Amount can't be null when creating new mail deposit");
        }

        $params = [
            'Deposit_ID' => $deposit_id,
            'Method' => $deposit_method,
        ];

        if ($deposit_method === DepositMethod::CREATE) {
            $params['Mail_Address'] = $mail_address;
            $params['Shop_Mail_Address'] = $shop_mail_address;
            $params['Mail_Deposit_Account_Name'] = $account_name;
            $params['Expire'] = $expire;
            $params['Amount'] = $amount;

        }

        return $this->invoke(__FUNCTION__, $params);
    }

    /**
     * search transferred or deposited into gmo registered bank account with deposit id
     * @param string $deposit_id
     *
     * @return array {
     *      Deposit_ID: string,
     *      Mail_Address: string,
     *      Shop_Mail_Address: string,
     *      Account_Name: string,
     *      Amount: string,
     *      Expire: string,
     *      Status: string,
     * }
     * @throws GmoPaymentException
     * @throws RemittanceException
     */
    public function mailDepositSearch(string $deposit_id)
    {
        return $this->invoke(__FUNCTION__, ['Deposit_ID' => $deposit_id]);
    }

    /**
     * @return array {
     *      Shop_ID: string,
     *      Balance: string,
     *      Balance_Forecast: string,
     * }
     * @throws GmoPaymentException
     * @throws RemittanceException
     */
    public function balanceSearch()
    {
        return $this->invoke(__FUNCTION__, []);
    }

    /**
     * @param string $func
     * @param array $params
     * @param array $headers
     * @return array
     * @throws GmoPaymentException
     * @throws RemittanceException
     */
    protected function invoke(string $func, array $params = [], array $headers = [])
    {
        if (!$this->url) {
            throw new RemittanceException('Please specify remittance_url in gmo config');
        }
        if (!$this->shop_id ) {
            throw new RemittanceException('Please specify remittance_shop_id in gmo config');
        }
        if (!$this->shop_pass) {
            throw new RemittanceException('Please specify remittance_shop_pass in gmo config');
        }
        $params = array_merge($params, [
            'Shop_ID' => $this->shop_id,
            'Shop_Pass' => $this->shop_pass,
        ]);
        return parent::invoke($func, $params, $headers);
    }
}


