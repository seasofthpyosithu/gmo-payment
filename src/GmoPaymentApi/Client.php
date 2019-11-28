<?php

namespace Seasofthpyosithu\GmoPayment\GmoPaymentApi;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Client{

    /**
     * HTTP_USER_AGENT.
     */
    const HTTP_USER_AGENT = 'curl/7.30.0';
    /**
     * HTTP_ACCEPT.
     */
    const HTTP_ACCEPT = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';

    /**
     * @var string api url
     */
    protected $url;

    /**
     * @var GuzzleClient curl client
     */
    protected $client;

    protected $api = [
        'entryTran'                     => 'EntryTran.idPass',
        'execTran'                      => 'ExecTran.idPass',
        'alterTran'                     => 'AlterTran.idPass',
        'tdVerify'                      => 'SecureTran.idPass',
        'changeTran'                    => 'ChangeTran.idPass',
        'saveCard'                      => 'SaveCard.idPass',
        'deleteCard'                    => 'DeleteCard.idPass',
        'searchCard'                    => 'SearchCard.idPass',
        'tradedCard'                    => 'TradedCard.idPass',
        'saveMember'                    => 'SaveMember.idPass',
        'deleteMember'                  => 'DeleteMember.idPass',
        'searchMember'                  => 'SearchMember.idPass',
        'updateMember'                  => 'UpdateMember.idPass',
        'bookSalesProcess'              => 'BookSalesProcess.idPass',
        'unbookSalesProcess'            => 'UnbookSalesProcess.idPass',
        'searchBookingInfo'             => 'SearchBookingInfo.idPass',
        'searchTrade'                   => 'SearchTrade.idPass',
        'entryTranSuica'                => 'EntryTranSuica.idPass',
        'execTranSuica'                 => 'ExecTranSuica.idPass',
        'entryTranEdy'                  => 'EntryTranEdy.idPass',
        'execTranEdy'                   => 'ExecTranEdy.idPass',
        'entryTranCvs'                  => 'EntryTranCvs.idPass',
        'execTranCvs'                   => 'ExecTranCvs.idPass',
        'cvsCancel'                     => 'CvsCancel.idPass',
        'entryTranPayEasy'              => 'EntryTranPayEasy.idPass',
        'execTranPayEasy'               => 'ExecTranPayEasy.idPass',
        'entryTranPaypal'               => 'EntryTranPaypal.idPass',
        'execTranPaypal'                => 'ExecTranPaypal.idPass',
        'paypalStart'                   => 'PaypalStart.idPass',
        'cancelTranPaypal'              => 'CancelTranPaypal.idPass',
        'entryTranWebmoney'             => 'EntryTranWebmoney.idPass',
        'execTranWebmoney'              => 'ExecTranWebmoney.idPass',
        'webmoneyStart'                 => 'WebmoneyStart.idPass',
        'paypalSales'                   => 'PaypalSales.idPass',
        'cancelAuthPaypal'              => 'CancelAuthPaypal.idPass',
        'entryTranAu'                   => 'EntryTranAu.idPass',
        'execTranAu'                    => 'ExecTranAu.idPass',
        'auStart'                       => 'AuStart.idPass',
        'auCancelReturn'                => 'AuCancelReturn.idPass',
        'auSales'                       => 'AuSales.idPass',
        'deleteAuOpenID'                => 'DeleteAuOpenID.idPass',
        'entryTranDocomo'               => 'EntryTranDocomo.idPass',
        'execTranDocomo'                => 'ExecTranDocomo.idPass',
        'docomoStart'                   => 'DocomoStart.idPass',
        'docomoCancelReturn'            => 'DocomoCancelReturn.idPass',
        'docomoSales'                   => 'DocomoSales.idPass',
        'entryTranDocomoContinuance'    => 'EntryTranDocomoContinuance.idPass',
        'execTranDocomoContinuance'     => 'ExecTranDocomoContinuance.idPass',
        'docomoContinuanceSales'        => 'DocomoContinuanceSales.idPass',
        'docomoContinuanceCancelReturn' => 'DocomoContinuanceCancelReturn.idPass',
        'docomoContinuanceUserChange'   => 'DocomoContinuanceUserChange.idPass',
        'docomoContinuanceUserEnd'      => 'DocomoContinuanceUserEnd.idPass',
        'docomoContinuanceShopChange'   => 'DocomoContinuanceShopChange.idPass',
        'docomoContinuanceShopEnd'      => 'DocomoContinuanceShopEnd.idPass',
        'docomoContinuanceStart'        => 'DocomoContinuanceStart.idPass',
        'entryTranJibun'                => 'EntryTranJibun.idPass',
        'execTranJibun'                 => 'ExecTranJibun.idPass',
        'jibunStart'                    => 'JibunStart.idPass',
        'entryTranSb'                   => 'EntryTranSb.idPass',
        'execTranSb'                    => 'ExecTranSb.idPass',
        'sbStart'                       => 'SbStart.idPass',
        'sbCancel'                      => 'SbCancel.idPass',
        'sbSales'                       => 'SbSales.idPass',
        'entryTranAuContinuance'        => 'EntryTranAuContinuance.idPass',
        'execTranAuContinuance'         => 'ExecTranAuContinuance.idPass',
        'auContinuanceStart'            => 'AuContinuanceStart.idPass',
        'auContinuanceCancel'           => 'AuContinuanceCancel.idPass',
        'auContinuanceChargeCancel'     => 'AuContinuanceChargeCancel.idPass',
        'entryTranJcbPreca'             => 'EntryTranJcbPreca.idPass',
        'execTranJcbPreca'              => 'ExecTranJcbPreca.idPass',
        'jcbPrecaBalanceInquiry'        => 'JcbPrecaBalanceInquiry.idPass',
        'jcbPrecaCancel'                => 'JcbPrecaCancel.idPass',
        'searchTradeMulti'              => 'SearchTradeMulti.idPass',
        'entryTranVirtualaccount'       => 'EntryTranVirtualaccount.idPass',
        'execTranVirtualaccount'        => 'ExecTranVirtualaccount.idPass'
    ];


    /**
     * Client constructor.
     * @throws Exception
     */
    public function __construct()
    {
        if (!$this->url) {
            throw new Exception('missing api url');
        }

        $this->client = new GuzzleClient([
            'base_uri' => $this->url
        ]);
    }

    /**
     * @param string $func function name
     * @param array $params
     * @param array $headers
     * @return array
     * @throws GmoPaymentException
     */
    protected function invoke(string $func, array $params = [], array $headers = []) {
        if (!isset($this->api[$func])) {
            throw new GmoPaymentException("api doesn't not exist", 0, null, '');
        }
        try {
            $headers = array_merge([
                'Content-Type' => 'application/x-www-form-urlencoded;charset=Shift_JIS',
            ], $headers);
            $response = $this->client->post($this->api[$func], [
                'form_params' => $params,
                'headers' => $headers,
            ]);

            $result = $this->result2Array($response->getBody()->getContents());
            if ($this->checkError($result)) {
                throw new GmoPaymentException($result['ErrCode'] . ' : ' . $result['ErrInfo'], 0, null, $result['ErrInfo']);
            }
            return $result;
        } catch (RequestException $e) {
            throw $e;
        }

    }

    /**
     *
     * @param array $arr
     * @return bool
     */
    private function checkError(array $arr) {
        if (isset($arr['ErrCode'])) {
            return true;
        }
        return false;
    }

    /**
     * @param string $str
     * @return array
     */
    private function result2Array(string $str) {
        $d = [];
        $arr = explode("&", $str);
        foreach ($arr as $val) {
            $item = explode("=", $val);
            $d[$item[0]] = $item[1];
        }
        return $d;
    }

    protected function defaultHeaders()
    {
        $h = [];
        // Add user agent.
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $h['HttpUserAgent'] = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $h['HttpUserAgent'] = self::HTTP_USER_AGENT;
        }
        // Add accept.
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            $h['HttpAccept'] = $_SERVER['HTTP_ACCEPT'];
        } else {
            $h['HttpAccept'] = self::HTTP_ACCEPT;
        }

        return $h;
    }
}

