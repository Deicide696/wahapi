<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class PaymentForm extends CFormModel
{
    public $primaryAccountNumber;
    public $cardHolderName;
    public $expirationMonth;
    public $expirationYear;
    public $cvc;
    public $amount;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('primaryAccountNumber, cardHolderName, expirationMonth, expirationYear, cvc, amount', 'required'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'primaryAccountNumber'=>'Número de la Tarjeta de Credito',
            'cardHolderName'=>'Nombre',
            'expirationMonth'=>'Mes de expiración',
            'expirationYear'=>'Año de expiración',
            'cvc'=>'CVC',
            'amount'=>'amount'
        );
    }
}