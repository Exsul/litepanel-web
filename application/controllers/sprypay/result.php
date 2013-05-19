<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 29.12.2012
* @Developed by QuickDevel
*/
class resultController extends Controller {
	public function index()
	{
		$this->load->model('users');
		$this->load->model('invoices');
		
		if($this->request->server['REQUEST_METHOD'] != 'POST')
		  exit("error Invalid request!");
     	if (!$this->validatePOST())
     	  exit("error $errorPOST");
		$ammount = $this->request->post['spAmount'];
		$invid = $this->request->post['spShopPaymentId'];
		//$signature = $this->request->post['SignatureValue'];
		
		$invoice = $this->invoicesModel->getInvoiceById($invid);
		$userid = $invoice['user_id'];
		
		$this->usersModel->upUserBalance($userid, $ammount);
		$this->invoicesModel->updateInvoice($invid, array('invoice_status' => 1));
		exit("ok");
	}
	
	private function validatePOST()
	{
		$_POST = $this->request->post;
		// список переменных, которые должны присутствовать в запросе с данными платежа
		$spQueryFields = array('spPaymentId', 'spShopId', 'spShopPaymentId', 'spBalanceAmount', 'spAmount', 'spCurrency', 'spCustomerEmail', 'spPurpose', 'spPaymentSystemId', 'spPaymentSystemAmount', 'spPaymentSystemPaymentId', 'spEnrollDateTime', 'spHashString', 'spBalanceCurrency');

		// проверим, что все они присутутвуют в запросе
		foreach($spQueryFields as $spFieldName)
		  if (!isset($_POST[$spFieldName]))
		    exit("error в запросе с данными платежа отсутствует параметр `$spFieldName`");
 
		// ваш секретный ключ, задается в настройках магазина
		$yourSecretKeyString = 'qwerty';
 
		// получим контрольную подпись
		$localHashString = md5($_POST['spPaymentId'].$_POST['spShopId'].$_POST['spShopPaymentId'].$_POST['spBalanceAmount'].$_POST['spAmount'].$_POST['spCurrency'].$_POST['spCustomerEmail'].$_POST['spPurpose'].$_POST['spPaymentSystemId'].$_POST['spPaymentSystemAmount'].$_POST['spPaymentSystemPaymentId'].$_POST['spEnrollDateTime'].$yourSecretKeyString);
 
		// сравним полученную подпись и ту, что пришла с запросом
		if ($localHashString != $_POST['spHashString'])
			exit("error не совпали подписи; локальная: `$localHashString`; в запросе:`".$_POST['spHashString']."`");		
		
		return true;
	}
}
?>
