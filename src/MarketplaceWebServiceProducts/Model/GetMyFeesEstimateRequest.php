<?php
/*******************************************************************************
 * Copyright 2009-2016 Amazon Services. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 *
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at: http://aws.amazon.com/apache2.0
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR 
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the 
 * specific language governing permissions and limitations under the License.
 *******************************************************************************
 * PHP Version 5
 * @category Amazon
 * @package  Marketplace Web Service Products
 * @version  2011-10-01
 * Library Version: 2016-06-01
 * Generated: Mon Jun 13 10:07:56 PDT 2016
 */

/**
 *  @see MarketplaceWebServiceProducts_Model
 */

require_once(dirname(__FILE__) . '/../MarketplaceWebServiceProducts_Model.php');


/**
 * MarketplaceWebServiceProducts_Model_GetMyFeesEstimateRequest
 * 
 * Properties:
 * <ul>
 * 
 * <li>SellerId: string</li>
 * <li>MWSAuthToken: string</li>
 * <li>FeesEstimateRequestList: MarketplaceWebServiceProducts_Model_FeesEstimateRequestList</li>
 *
 * </ul>
 */

 class MarketplaceWebServiceProducts_Model_GetMyFeesEstimateRequest extends MarketplaceWebServiceProducts_Model {

    public function __construct($data = null)
    {
    $this->_fields = array (
    'SellerId' => array('FieldValue' => null, 'FieldType' => 'string'),
    'MWSAuthToken' => array('FieldValue' => null, 'FieldType' => 'string'),
    'FeesEstimateRequestList' => array('FieldValue' => null, 'FieldType' => 'MarketplaceWebServiceProducts_Model_FeesEstimateRequestList'),
    );
    parent::__construct($data);
    }

    /**
     * Get the value of the SellerId property.
     *
     * @return String SellerId.
     */
    public function getSellerId()
    {
        return $this->_fields['SellerId']['FieldValue'];
    }

    /**
     * Set the value of the SellerId property.
     *
     * @param string sellerId
     * @return this instance
     */
    public function setSellerId($value)
    {
        $this->_fields['SellerId']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Check to see if SellerId is set.
     *
     * @return true if SellerId is set.
     */
    public function isSetSellerId()
    {
                return !is_null($this->_fields['SellerId']['FieldValue']);
            }

    /**
     * Set the value of SellerId, return this.
     *
     * @param sellerId
     *             The new value to set.
     *
     * @return This instance.
     */
    public function withSellerId($value)
    {
        $this->setSellerId($value);
        return $this;
    }

    /**
     * Get the value of the MWSAuthToken property.
     *
     * @return String MWSAuthToken.
     */
    public function getMWSAuthToken()
    {
        return $this->_fields['MWSAuthToken']['FieldValue'];
    }

    /**
     * Set the value of the MWSAuthToken property.
     *
     * @param string mwsAuthToken
     * @return this instance
     */
    public function setMWSAuthToken($value)
    {
        $this->_fields['MWSAuthToken']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Check to see if MWSAuthToken is set.
     *
     * @return true if MWSAuthToken is set.
     */
    public function isSetMWSAuthToken()
    {
                return !is_null($this->_fields['MWSAuthToken']['FieldValue']);
            }

    /**
     * Set the value of MWSAuthToken, return this.
     *
     * @param mwsAuthToken
     *             The new value to set.
     *
     * @return This instance.
     */
    public function withMWSAuthToken($value)
    {
        $this->setMWSAuthToken($value);
        return $this;
    }

    /**
     * Get the value of the FeesEstimateRequestList property.
     *
     * @return FeesEstimateRequestList FeesEstimateRequestList.
     */
    public function getFeesEstimateRequestList()
    {
        return $this->_fields['FeesEstimateRequestList']['FieldValue'];
    }

    /**
     * Set the value of the FeesEstimateRequestList property.
     *
     * @param MarketplaceWebServiceProducts_Model_FeesEstimateRequestList feesEstimateRequestList
     * @return this instance
     */
    public function setFeesEstimateRequestList($value)
    {
        $this->_fields['FeesEstimateRequestList']['FieldValue'] = $value;
        return $this;
    }

    /**
     * Check to see if FeesEstimateRequestList is set.
     *
     * @return true if FeesEstimateRequestList is set.
     */
    public function isSetFeesEstimateRequestList()
    {
                return !is_null($this->_fields['FeesEstimateRequestList']['FieldValue']);
            }

    /**
     * Set the value of FeesEstimateRequestList, return this.
     *
     * @param feesEstimateRequestList
     *             The new value to set.
     *
     * @return This instance.
     */
    public function withFeesEstimateRequestList($value)
    {
        $this->setFeesEstimateRequestList($value);
        return $this;
    }

}
